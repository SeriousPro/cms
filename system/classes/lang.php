<?php

/**
 * User: Marcel 'CoNfu5eD Naeve <confu5ed@serious-pro.de>
 * Date: 03.03.2016
 * Time: 14:08
 */

/**
 * Class Lang - language handling class
 */
class Lang
{
    /**
     * Alias for tr function which translates a string to another language.
     * @param $str string - string to be translated
     * @param $base_dir string|array - directory(s) containing a languages directory in priority order
     * @param $lang string - language to translate to if not current/default language
     * @return string translated string
     */
    static function translate($str, $base_dir="", $lang="") {
        return Lang::tr($str, $base_dir, $lang);
    }

    /**
     * Function for translating a string to another language.
     * @param $str string - string to be translated
     * @param $base_dir string|array - directory(s) containing a languages directory in priority order
     * @param $lang string - language to translate to if not current/default language
     * @return string translated string
     */
    static function tr($str, $base_dir="", $lang="") {
        if(trim($lang)=="") $lang = $_SESSION['language'];
        if(is_array($base_dir)) {
            $base_dirs = $base_dir;
        } else {
            $base_dirs = [$base_dir];
        }
        for($i=0;$i<count($base_dirs);$i++) {
            if(file_exists($base_dirs[$i]."/languages/$lang.php")) {
                include ($base_dirs[$i]."/languages/$lang.php");
                if(isset($tr[$lang]) && isset($tr[$lang][$str])) {
                    return $tr[$lang][$str];
                } else {
                    return $str;
                }
            }
        }
        return "";
    }

    /**
     * Function for selecting the current (session) language.
     */
    static function select() {
        if(isset($_POST['switch_language'])) {
            $_SESSION['language'] = $_POST['switch_language'];
            return;
        }
        if(isset($_GET['lang'])) {
            $_SESSION['language'] = $_GET['lang'];
            return;
        }
        $_SESSION['language'] = DEFAULT_LANGUAGE;
    }
}

// select language
Lang::select();
