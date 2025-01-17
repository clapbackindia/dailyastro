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

class CbDailyAstroDb extends BxBaseModGeneralDb
{
    function __construct(&$oConfig) 
    {
        parent::__construct($oConfig);
    }
}

/** @} */
