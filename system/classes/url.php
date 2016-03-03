<?php
/**
 * Created by PhpStorm.
 * User: Marcel 'CoNfu5eD Naeve <confu5ed@serious-pro.de>
 * Date: 28.02.2016
 * Time: 15:09
 */

/**
 * Class Url - Patchable utility class for creating urls and reading url data.
 */
class Url
{

    static $GET_PLAIN = 0;
    static $GET_PRINT = 1;

    /**
     * Get the Complete link to media files, also usefull for CDN usage (prefix = cdnurl).
     * @param $path string - local path to file you wanna link to.
     * @return string - the complete url to the media file.
     */
    static function media($path) {
        return MEDIAURL_PREFIX . $path;
    } /* -- end Url::media() -- */

    /**
     * Generates SiteUrl with 3 parameters.
     * @param $s string - Site name (Plugin Name)
     * @param $p string - Parameters (syntax defined by plugin)
     * @param $l string - Language (de/en/jp/es/fr/..)
     * @return string Url
     */
    static function generateSiteUrl($s, $p, $l) {
        return "index.php?site=$s&params=$p&lang=$l";
    } /* -- end Url::generateSiteUrl() -- */

    /**
     * Site Url generation with more complexity than generateSiteUrl.
     * @param $data array|object|string - string can be json or custom syntax (see documentation).
     * @return string Url
     */
    static function site($data) {
        if(is_array($data)) {
            if(isset($data['site']))    $s = $data['site'];
            if(isset($data['lang']))    $l = $data['lang'];
            if(isset($data['params']))  $p = $data['params'];
        }
        elseif(is_object($data)) {
            if(isset($data->site))      $s = $data->site;
            if(isset($data->lang))      $l = $data->lang;
            if(isset($data->params))    $p = $data->params;
        }
        elseif(is_string($data)) {
            switch(mb_substr($data, 0, 2)) {
                case "s:": $s = mb_substr($data, 2, mb_strlen($data)-2); break;
                case "p:": $p = mb_substr($data, 2, mb_strlen($data)-2); break;
                case "l:": $l = mb_substr($data, 2, mb_strlen($data)-2); break;
                default:
                    $d = json_decode($data);
                    if($d) return Url::site($d);
                    break;
            }
        }
        else {
            return "";
        }

        if(!isset($s) && isset($_GET['site']))      $s = $_GET['site'];
        if(!isset($l) && isset($_GET['lang']))      $l = $_GET['lang'];
        if(!isset($p) && isset($_GET['params']))    $p = $_GET['params'];

        if(!isset($l)) { $l = DEFAULT_LANGUAGE; }

        return Url::generateSiteUrl($s, $p, $l);
    } /* -- end Url::site() -- */

    /**
     * @param $name string function name
     * @param $arguments array function arguments
     * @return string|null
     */
    function __callStatic($name, $arguments)
    {
        if(mb_substr($name, 0, 3) == "get") {
            $gp = mb_strtolower(mb_substr($name, 3, mb_strlen($name)-3));
            $v = $_GET[$gp];
            if(!isset($arguments) || !isset($arguments[0])) return $v;
            switch(mb_strtolower($arguments[0])) {
                case Url::$GET_PLAIN: return $v;
                case Url::$GET_PRINT: return htmlentities($v);
            }
        }
        return null;
    } /* --- end Url::* --- */
}