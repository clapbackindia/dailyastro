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

bx_import('BxDolModuleDb');

class CbDailyAstroDb extends BxDolModuleDb
{
    function __construct(&$oConfig) 
    {
        parent::__construct($oConfig);
    }

    /**
     * Get the daily astro message from the database
     *
     * @return string|null The daily astro message or null if not found
     */
    // public function getDailyAstroMessage()
    // {
    //     $sQuery = "SELECT message FROM `cb_daily_astro` WHERE `id` = 1 LIMIT 1";
    //     return $this->getOne($sQuery);
    // }
}

/** @} */
