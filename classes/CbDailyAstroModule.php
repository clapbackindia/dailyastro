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

class CbDailyAstroModule extends BxDolModule 
{
    /**
     * Cached daily astro message
     * @var string|null
     */
    protected ?string $sDailyAstroMessage = null;

    /**
     * Class constructor
     *
     * This method is called when the class is instantiated and is used to
     * initialize the class' properties.
     *
     * @param array $aModule module registration information
     */
    function __construct(&$aModule) 
    {
        parent::__construct($aModule);
        /**
         * Add CSS file to the page
         *
         * This CSS file contains styles for the daily astro module.
         */
        $this->_oTemplate->addCss(array('daily_astro.css'));
    }

    /**
     * Put astro message to cache
     * 
     * @param string $sMessage Message to cache
     */
    // public function putAstroToCache($sMessage)
    // {
    //     $oCachObject = $this->_oDb->getDbCacheObject();
    //     $oCachObject->setData($this->_oDb->genDbCacheKey($this->_oConfig->CNF['CACHEKEY']), $sMessage, CB_DAILY_ASTRO_LIFETIME_IN_SECONDS);
    // }

    /**
     * Get astro message from cache
     * 
     * @return string|null Cached message or null if not found
     */
    // public function getAstroFromCache()
    // {
    //     $oCachObject = $this->_oDb->getDbCacheObject();
    //     return $oCachObject->getData($this->_oDb->genDbCacheKey($this->_oConfig->CNF['CACHEKEY']), CB_DAILY_ASTRO_LIFETIME_IN_SECONDS);
    // }

    /**
     * Remove astro message from cache
     */
    // public function removeAstroFromCache()
    // {
    //     $oCachObject = $this->_oDb->getDbCacheObject();
    //     $oCachObject->delData($this->_oDb->genDbCacheKey($this->_oConfig->CNF['CACHEKEY']));
    // }

    /**
     * Get the daily astro message from the database.
     *
     * This method retrieves the daily astro message from the database if it is not already cached
     * in the instance variable. It uses the database class to fetch the message.
     *
     * @return string Daily astro message
     */
    protected function getDailyAstroMessage()
    {
        // try {
        //     // Check cache first
        //     $sMessage = $this->getAstroFromCache();
        //     if (!empty($sMessage)) {
        //         return $sMessage;
        //     }

        //     // Get message from database using DB class
        //     $sMessage = $this->_oDb->getDailyAstroMessage();

        //     // Validate and cache the result
        //     if (!empty($sMessage)) {
        //         $this->putAstroToCache($sMessage);
        //         return $sMessage;
        //     }

        //     return 'No daily astro message available.';
        // } catch (Exception $e) {
        //     return 'Unable to retrieve daily astro message.';
        // }
        return 'Daily astro message.';
    }

    /**
     * Service method to display the daily astro message
     * @return string HTML content
     */
    public function serviceAstro() 
    {
        try {
            // Get the daily astro message from the database
            $sDailyAstroMessage = $this->getDailyAstroMessage();

            if (empty($sDailyAstroMessage)) {
                return 'No daily message available.';
            }
            // Create HTML content
            return '<div class="cb-daily-astro-container">' . htmlspecialchars($sDailyAstroMessage) . '</div>';
        } catch (Exception $e) {
            return 'Error loading astro message.';
        }
    }

    /**
     * Service method to get the daily astro block
     * @return array Block configuration
     */
    public function serviceGetBlock() 
    {
        try {
            // Get the daily astro message from the database
            $sContent = $this->serviceAstro();
            // Set up the block configuration
            $aBlock = array(
                'content' => $sContent
            );
            // Return the block configuration
            return $aBlock;
        } catch (Exception $e) {
            return array('content' => 'Error loading daily astro message');
        }
    }
}

/** @} */
