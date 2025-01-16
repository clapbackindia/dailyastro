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

bx_import('BxDolModuleConfig');

class CbDailyAstroConfig extends BxDolModuleConfig 
{
    public $CNF;

    function __construct($aModule) 
    {
        parent::__construct($aModule);

        $this->CNF = array(
            'CACHEKEY' => 'cb_daily_astro'
        );
    }   
}

/** @} */
