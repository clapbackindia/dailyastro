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

bx_import ('BxDolModuleTemplate');

class CbDailyAstroTemplate extends BxDolModuleTemplate 
{    
    /**
     * Constructor for CbDailyAstroTemplate class.
     *
     * Initializes the template with the provided configuration and database objects.
     *
     * @param object $oConfig Configuration object for the module.
     * @param object $oDb Database object for the module.
     */
    function __construct(&$oConfig, &$oDb) 
    {
	    parent::__construct($oConfig, $oDb);
        $this->addCss(['daily_astro.css']);
    } 
}

/** @} */
