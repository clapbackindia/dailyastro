<?php 
/**
* Copyright (c) Clapback Pvt Ltd - https://clapback.net
* MIT License - https://opensource.org/licenses/MIT
*
* @defgroup    DailyAstro Astro module
* @ingroup     UnaModules
*
* @{
*/

$aConfig = array(
	/**
	 * Main Section.
	 */
	'type' => BX_DOL_MODULE_TYPE_MODULE,
    'name' => 'cb_dailyastro',
	'title' => 'Daily Astro',
    'note' => 'Daily Astro modules',
	'version' => '1.0.0',
	'vendor' => 'clapBack',
    'help_url' => 'https://www.clapback.net/',

	'compatible_with' => array(
        '14.0.0-RC2'
    ),

    /**
	 * 'home_dir' and 'home_uri' - should be unique. Don't use spaces in 'home_uri' and the other special chars.
	 */
	'home_dir' => 'clapback/dailyastro/',
	'home_uri' => 'dailyastro',
	
	'db_prefix' => 'cb_dailyastro_',
	'class_prefix' => 'CbDailyAstro',

	/**
	 * Category for language keys.
	 */
	'language_category' => 'DailyAstro',

	/**
	 * Installation/Uninstallation Section.
	 */
	'install' => array(
		'execute_sql' => 1,
        'update_languages' => 1,
        'clear_db_cache' => 1,
	),
	'uninstall' => array (
		'execute_sql' => 1,
        'update_languages' => 1,
        'clear_db_cache' => 1,
    ),
    'enable' => array(
        'execute_sql' => 1,
        'recompile_global_parameters' => 1,
        'clear_db_cache' => 1,
    ),
	'enable_success' => array(
        'clear_db_cache' => 1,
    ),
    'disable' => array(
        'execute_sql' => 1,
        'recompile_global_parameters' => 1,
        'clear_db_cache' => 1,
    ),
	'disable_failed' => array (
        'clear_db_cache' => 1,
    ),

    /**
	 * Dependencies Section
	 */
	'dependencies' => array(
		//'sys_objects_page_blocks'
	),

);

/** @} */
