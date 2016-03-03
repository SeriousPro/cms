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
 * Define Constant - Security Check
 * File can check now it has been included to index.php with:
 * if(defined('INDEX')) { ... }
 */
define('INDEX', true);

/*
 * Define Constants - Basic Paths
 */
define ('__TEMP_DIR__',     __DIR__ . "/themes");
define ('__SYSTEM_DIR__',   __DIR__ . "/system");
define ('__PLUGINS_DIR__',  __DIR__ . "/plugins");
define ('__THEMES_DIR__',   __DIR__ . "/themes");

