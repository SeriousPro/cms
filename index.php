<?php
/**
 * User: Marcel 'CoNfu5eD Naeve <confu5ed@serious-pro.de>
 * Date: 03.03.2016
 * Time: 11:35
 */

/*
 * Starting Session
 */
session_start();

/*
 * Set encoding to UTF-8
 */
mb_internal_encoding("UTF-8");
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_regex_encoding('UTF-8');

/*
 * Define Constant - Security Check
 * File can check now it has been included to index.php with:
 * if(defined('INDEX')) { ... }
 */
define('INDEX', true);

/*
 * Define Constants - Basic Paths
 */
define ('__TEMP_DIR__',         __DIR__ . "/temp");
define ('__SYSTEM_DIR__',       __DIR__ . "/system");
define ('__PLUGINS_DIR__',      __DIR__ . "/plugins");
define ('__THEMES_DIR__',       __DIR__ . "/themes");
define ('__CONFIGS_DIR__',      __SYSTEM_DIR__ . "/configs");
define ('__FUNCTIONS_DIR__',    __SYSTEM_DIR__ . "/functions");
define ('__CLASSES_DIR__',      __SYSTEM_DIR__ . "/classes");


/*
 * Load Configuration Files
 */
include_once (__SYSTEM_DIR__ . "/load.config.php");

/*
 * Load Functions
 */
include_once (__SYSTEM_DIR__ . "/load.functions.php");

/*
 * Load Class Files
 */
include_once (__SYSTEM_DIR__ . "/load.classes.php");

/*
 * Select theme
 */
select_theme();

/*
 * Load Theme and/or Content
 */
$cms_plugin_use_no_theme = false; // allows plugins to disable theme for example for rss/atom feeds.
ob_start();
include_once (__THEMES_DIR__ . "/${_SESSION['theme']}/theme.php");
if($cms_plugin_use_no_theme) {
    ob_end_clean();
    Plugin::body(Plugin::select(), $_GET['params']);
} else {
    ob_end_flush();
}
