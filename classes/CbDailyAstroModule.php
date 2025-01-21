<?php defined('BX_DOL') or die('hack attempt');

/**
 * Copyright (c) Clapback Pvt Ltd - https://clapback.net
 * MIT License - https://opensource.org/licenses/MIT
 *
 * @defgroup    DailyAstro Daily Astro module
 * @ingroup     UnaModules
 *
 * @{
 */

bx_import('BxDolModule');

define('CB_DAILY_ASTRO_LIFETIME_IN_SECONDS', 86400);

final class CbDailyAstroModule extends BxDolModule 
{
    private const ERROR_MESSAGE = 'Error loading astro message.';
    private const NO_MESSAGE = 'No astro message available.';
    private const PROFILE_MISSING = 'Please update your Date of Birth in your profile.';
    private const API_ENDPOINT = 'https://horoscope-app-api.vercel.app/api/v1/get-horoscope/daily';
    private const ZODIAC_DATES = [
        [1, 20, 'Capricorn'],
        [2, 19, 'Aquarius'],
        [3, 20, 'Pisces'],
        [4, 20, 'Aries'],
        [5, 21, 'Taurus'],
        [6, 21, 'Gemini'],
        [7, 22, 'Cancer'],
        [8, 23, 'Leo'],
        [9, 23, 'Virgo'],
        [10, 23, 'Libra'],
        [11, 22, 'Scorpio'],
        [12, 22, 'Sagittarius'],
        [12, 31, 'Capricorn']
    ];
    private readonly ?BxDolProfile $oProfile;
    private ?string $dailyAstroMessage = null;

    public function __construct(array &$aModule) 
    {
        parent::__construct($aModule);
        $this->oProfile = BxDolProfile::getInstance();
    }

    /**
     * Generate a unique cache key for a specific zodiac sign.
     *
     * This method creates a cache key by combining the configured cache key prefix,
     * the zodiac sign, and the current date. The generated cache key is used to
     * store and retrieve horoscope data specific to the zodiac sign.
     *
     * @param string $sign The zodiac sign for which to generate the cache key.
     * @return string The generated cache key.
     */
    private function generateSignCacheKey(string $sign): string 
    {
        // Generate the current date key in the format 'Y-m-d'
        $dateKey = date('Y-m-d');
        // Return the generated cache key using the database's cache key generator
        return $this->_oDb->genDbCacheKey(
            "{$this->_oConfig->CNF['CACHEKEY']}_{$sign}_{$dateKey}"
        );
    }

    /**
     * Retrieve the cached horoscope for a specific zodiac sign.
     *
     * This method attempts to fetch the horoscope message for the given
     * zodiac sign from the cache. If the message is not available or
     * expired, it will return null.
     *
     * @param string $sign The zodiac sign for which to retrieve the cached horoscope.
     * @return string|null The cached horoscope message or null if not found.
     */
    private function getCachedHoroscope(string $sign): ?string 
    {
        // Generate a unique cache key based on the zodiac sign and current date
        $cacheKey = $this->generateSignCacheKey($sign);
        // Attempt to retrieve the cached horoscope message using the generated key
        return $this->_oDb->getDbCacheObject()->getData(
            $cacheKey,
            CB_DAILY_ASTRO_LIFETIME_IN_SECONDS
        );
    }

    /**
     * Cache horoscope for a specific zodiac sign.
     *
     * This method stores the horoscope message for a given zodiac sign
     * in the cache with a specific expiration time.
     * 
     * @param string $sign The zodiac sign for which to cache the message.
     * @param string $message The horoscope message to be cached.
     */
    private function cacheHoroscope(string $sign, string $message): void 
    {
        // Generate a unique cache key based on the zodiac sign and current date
        $cacheKey = $this->generateSignCacheKey($sign);

        // Store the horoscope message in the cache with a defined lifetime
        $this->_oDb->getDbCacheObject()->setData(
            $cacheKey,
            $message,
            CB_DAILY_ASTRO_LIFETIME_IN_SECONDS
        );
    }

    /**
     * Fetch horoscope from API for a specific sign
     * 
     * The method fetches the horoscope from the API endpoint using the 'sign' and 'day'
     * parameters. It uses the `file_get_contents` method to fetch the data from the API
     * and uses the `json_decode` method to parse the JSON response. If the response is
     * invalid or if the API request fails, it throws a RuntimeException.
     * 
     * @param string $sign The zodiac sign to fetch the horoscope for.
     * 
     * @throws RuntimeException If the API request fails or if the response is invalid.
     * 
     * @return string The daily horoscope for the given zodiac sign.
     */
    private function fetchHoroscopeFromApi(string $sign): string 
    {
        // Create a stream context with a timeout of 5 seconds
        $context = stream_context_create([
            'http' => [
                'timeout' => 5,
                'ignore_errors' => true
            ]
        ]);

        // Construct the API URL with the 'sign' and 'day' parameters
        $url = self::API_ENDPOINT . '?' . http_build_query([
            'sign' => strtolower($sign),
            'day' => 'TODAY'
        ]);

        // Fetch the data from the API using the stream context
        $response = file_get_contents($url, false, $context);
        
        // Check if the response is valid
        if ($response === false) {
            throw new RuntimeException('Failed to fetch horoscope from API');
        }

        // Parse the JSON response
        $data = json_decode($response, true);
        
        // Check if the JSON response is valid
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Invalid JSON response from API');
        }

        // Return the horoscope data
        return $data['data']['horoscope_data'] ?? throw new RuntimeException('Invalid API response structure');
    }

    /**
     * Get the zodiac sign based on birth date
     * 
     * This method retrieves the profile's date of birth and determines the zodiac sign
     * corresponding to that date. It uses predefined date ranges for each zodiac sign.
     * 
     * @throws InvalidArgumentException if the date format is invalid.
     * @throws RuntimeException if profile information is missing.
     * 
     * @return string The zodiac sign associated with the birth date.
     */
    private function getZodiacSign(): string 
    {
        // Retrieve profile information
        $profileInfo = $this->oProfile?->getInfo();
        if (!$profileInfo) {
            throw new RuntimeException(self::PROFILE_MISSING);
        }

        // Get module information for the viewer's profile
        $viewerModule = $this->oProfile->getModule();
        $viewerInfo = bx_srv($viewerModule, 'get_info', [$this->oProfile->getContentId(), false]);

        // Ensure viewer information is available and valid
        if (empty($viewerInfo) || !is_array($viewerInfo)) {
            throw new RuntimeException(self::PROFILE_MISSING);
        }

        // Extract and validate the date of birth
        $dateOfBirth = $viewerInfo['birthday'] ?? throw new RuntimeException(self::PROFILE_MISSING);

        try {
            // Convert the date of birth into a DateTimeImmutable object
            $date = new DateTimeImmutable($dateOfBirth);
            $month = (int)$date->format('n');
            $day = (int)$date->format('j');

            // Determine the zodiac sign based on predefined date ranges
            foreach (self::ZODIAC_DATES as [$zodiacMonth, $zodiacDay, $sign]) {
                if ($month < $zodiacMonth || ($month === $zodiacMonth && $day <= $zodiacDay)) {
                    return $sign;
                }
            }

            // Default zodiac sign for dates after the last date range in December
            return 'Capricorn';
        } catch (Throwable $e) {
            throw new InvalidArgumentException(
                "Invalid date format. Please use YYYY-MM-DD format.",
                previous: $e
            );
        }
    }

    /**
     * Get daily horoscope message
     *
     * This method fetches the daily horoscope message from the API or cache.
     * If there is an error, it will log the error and return a default error
     * message.
     *
     * @return string The daily astro message
     */
    private function getDailyAstroMessage(): string 
    {
        try {
            $sign = $this->getZodiacSign();
            // Check cache first
            $cachedMessage = $this->getCachedHoroscope($sign);
            if ($cachedMessage !== null) {
                // If cached, return the cached message
                return $cachedMessage;
            }
            // Fetch from API if not cached
            $message = $this->fetchHoroscopeFromApi($sign);
            $astrosign = BX_DOL_URL_ROOT."/modules/clapback/dailyastro/template/images/astro-signs/".$sign.".svg";
            $message = sprintf(
                            '<div class="cb-daily-astro-container"><h4 class="heading-h4"><i class="fa fa-atom"></i> Daily Astro Scope</h4><img src="%s" alt="%s" />%s</div>',
                            htmlspecialchars($astrosign, ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($sign, ENT_QUOTES, 'UTF-8'),
                            htmlspecialchars($message, ENT_QUOTES, 'UTF-8')
                        );
            // Cache the new message
            $this->cacheHoroscope($sign, $message);
            // Return the fetched message
            return $message;
        } catch (RuntimeException $e) {
            // If there is a runtime error, log the error
            error_log("Daily Astro Error: " . $e->getMessage());
            // Return a default error message
            return self::ERROR_MESSAGE;
        } catch (Throwable $e) {
            // If there is an unexpected error, log the error
            error_log("Unexpected Daily Astro Error: " . $e->getMessage());
            // Return a default error message
            return self::ERROR_MESSAGE;
        }
    }

    /**
     * Service method to display the daily astro message
     * 
     * This method is called from the UNA CMS page builder and displays the
     * daily astro message on the page.
     * 
     * @return string The HTML content of the daily astro message block.
     */
    public function serviceAstro(): string 
    {
        // Get the daily astro message from the database or from the API
        $message = $this->getDailyAstroMessage();
        // Return the block content
        return $message;
    }

    /**
     * Service method to get the daily astro block
     * 
     * @return array
     */
    public function serviceGetBlock(): array 
    {
        // Get the daily astro message
        $message = $this->getDailyAstroMessage();
        // Return the block content
        return [
            'content' => $message
        ];
    }
}

/** @} */