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

bx_import(BX_DIRECTORY_PATH_INC . "design.inc.php");

check_logged();

BxBaseModTextRequest::processAsAction($GLOBALS['aModule'], $GLOBALS['aRequest']);

/** @} */
