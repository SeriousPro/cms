<?php

/**
 * User: Marcel 'CoNfu5eD Naeve <confu5ed@serious-pro.de>
 * Date: 03.03.2016
 * Time: 13:55
 */

/**
 * Class Plugin
 */
class Plugin
{

    /**
     * Function for printing the head of a site/plugin.
     * @param $plugin string - plugin name
     * @param $params string - plugin parameters (syntax defined by plugin)
     */
    static function head($plugin, $params="") {
        $requested_file =__PLUGINS_DIR__ . "/$plugin/head.php";
        if(file_exists($requested_file))
            include ($requested_file);
    }

    /**
     * Function for printing the body of a site/plugin.
     * @param $plugin string - plugin name
     * @param $params string - plugin parameters (syntax defined by plugin)
     */
    static function body($plugin, $params="") {
        $requested_file =__PLUGINS_DIR__ . "/$plugin/body.php";
        if(file_exists($requested_file))
            include ($requested_file);
    }

    /**
     * Function for printing breadcrumbs of a site/plugin.
     * @param $plugin string - plugin name
     * @param $params string - plugin parameters (syntax defined by plugin)
     * @param $split string - split between parts of breadcrumbs
     */
    static function breadcrumbs($plugin, $params="") {
        $requested_file =__PLUGINS_DIR__ . "/$plugin/breadcrumbs.php";
        if(file_exists($requested_file))
            include ($requested_file);
    }

    /**
     * Function for printing the name of the site/requested plugin.
     * @param $plugin string - plugin name
     * @param $params string - plugin parameters (syntax defined by plugin)
     */
    static function sitename($plugin, $params="") {
        $requested_file = __PLUGINS_DIR__ . "/$plugin/sitename.php";
        if(file_exists($requested_file))
            include ($requested_file);
    }

    /**
     * Function for checking a plugin needs to be displayed without theme (body only).
     * @param $plugin string - plugin name
     * @param $params string - plugin parameters (syntax defined by plugin)
     * @return bool false => include theme, true => load plugin body
     */
    static function notheme($plugin, $params="") {
        $requested_file = __PLUGINS_DIR__ . "/$plugin/disable_theme.php";
        if(file_exists($requested_file)) {
            include($requested_file);
        }
        return false;
    }

    /**
     * Function for printing standalone content of a plugin.
     * @param $plugin string - plugin name
     * @param $box string - box name (boxes/?.php)
     * @param $params array - parameters for the box
     */
    static function box($plugin, $box, $params=[]) {
        $requested_file = __PLUGINS_DIR__ . "/$plugin/boxes/$box.php";
        if(file_exists($requested_file))
            include ($requested_file);
    }

    /**
     * Load Libraries from Plugin.
     * @param $plugin string - Pluginname
     * @param $libs array|string - Library-Name (list_libs for all libs if list_libs.php exists)
     */
    static function libs($plugin, $libs="list_libs") {
        if(!is_array($libs)) {
            $requested_file = __PLUGINS_DIR__ . "/$plugin/libs/$libs.php";
            if (file_exists($requested_file))
                require_once($requested_file);
        } else {
            foreach($libs as $lib) {
                $requested_file = __PLUGINS_DIR__ . "/$plugin/libs/$lib.php";
                if (file_exists($requested_file))
                    require_once($requested_file);
            }
        }
    }

    /**
     * Add a plugin lib to autoload before loading Theme and Plugin.
     * @param $plugin string - Pluginname
     * @param $libs array|string - Library-Name (list_libs for all libs if list_libs.php exists)
     * @return bool|int successfully added to autoload?
     */
    static function addAutoload($plugin, $libs="list_libs") {
        $autoloadLibs = Config::get("plugins_libs_autoload");
        if($autoloadLibs) {
            if(!is_array($libs)) {
                if(!in_array(__PLUGINS_DIR__."/$plugin/$libs.php", $autoloadLibs)) {
                    $autoloadLibs[] = __PLUGINS_DIR__."/$plugin/$libs.php";
                }

            } else {
                foreach($libs as $lib) {
                    if(!in_array(__PLUGINS_DIR__."/$plugin/$lib.php", $autoloadLibs)) {
                        $autoloadLibs[] = __PLUGINS_DIR__."/$plugin/$lib.php";
                    }
                }

            }

        } else {
            if(Config::set("plugins_libs_autoload", [])) {
                return Plugin::addAutoload($plugin, $libs);
            }
        }

        return Config::set("plugins_libs_autoload", $autoloadLibs);
    }

    /**
     * Remove a plugin lib from autoload before loading Theme and Plugin.
     * @param $plugin string - Pluginname
     * @param $libs array|string - Library-Name (list_libs for all libs if list_libs.php exists)
     * @return bool|int successfully removed from autoload?
     */
    static function removeAutoload($plugin, $libs="list_libs") {
        $autoloadLibs = Config::get("plugins_libs_autoload");
        if($autoloadLibs) {
            if(!is_array($libs)) {
                if(($k = array_search(__PLUGINS_DIR__."/$plugin/$libs.php", $autoloadLibs)) !== false) {
                    unset($autoloadLibs[$k]);
                }
            } else {
                foreach($libs as $lib) {
                    if(($k = array_search(__PLUGINS_DIR__."/$plugin/$lib.php", $autoloadLibs)) !== false) {
                        unset($autoloadLibs[$k]);
                    }
                }
            }
            return Config::set("plugins_libs_autoload", $autoloadLibs);

        }

        return true;
    }

    /**
     * Autoload registered plugin libraries.
     */
    static function autoload() {
        $autoloadLibs = Config::get("plugins_libs_autoload");
        foreach($autoloadLibs as $lib) {
            if(file_exists($lib)) require_once $lib;
        }
    }

    /**
     * Function for getting the name of the plugin which has to be loaded.
     * @return string - site name (plugin name) which has to be loaded
     */
    static function select() {
        if(isset($_GET['site'])) {
            return $_GET['site'];
        }
        if(isset($_SESSION['default_site'])) {
            return $_SESSION['default_site'];
        }
        if(Config::get("plugins_default_site") != null) {
            return Config::get("plugins_default_site");
        }
        return "error";
    }

}
