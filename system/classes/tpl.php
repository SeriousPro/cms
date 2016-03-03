<?php
/**
 * User: Marcel 'CoNfu5eD Naeve <confu5ed@serious-pro.de>
 * Date: 03.03.2016
 * Time: 11:57
 */

/**
 * Class Tpl - easy to use template class.
 */
class Tpl
{
    /**
     * @var array - list of variables for the template
     */
    var $p = [];

    /**
     * @var string - path to the chosen template
     */
    var $tplPath = "";

    /**
     * Tpl constructor.
     * @param $tpl string - template name and sub-directory
     * @param string $plugin string - plugin name if its a plugin template
     * @param array $params array - variables for the template
     */
    function __construct($tpl, $plugin="", $params=[])
    {
        if(is_array($params) && count($params) > 0) {
            $this->p = $params;
        }
        /* Template File Hierarchy */
        $requested_files = [
            __THEMES_DIR__."/${_SESSION['theme']}/templates/$plugin/$tpl".( mb_substr($tpl, mb_strlen($tpl)-5, 4) == ".tpl" ),
            __THEMES_DIR__."/${_SESSION['theme']}/templates/$tpl".( mb_substr($tpl, mb_strlen($tpl)-5, 4) == ".tpl" ),
            __PLUGINS_DIR__."/$plugin/templates/$tpl".( mb_substr($tpl, mb_strlen($tpl)-5, 4) == ".tpl" ),
            __SYSTEM_DIR__."/templates/$tpl".( mb_substr($tpl, mb_strlen($tpl)-5, 4) == ".tpl" )
        ];
        for($i=0;$i<count($requested_files);$i++) {
            if(file_exists($requested_files[$i])) {
                $this->tplPath = $requested_files[$i];
            }
        }
    }

    /**
     * Prints out the template and gives parameters as variables to it.
     */
    function out() {
        if(file_exists($this->tplPath)) {
            extract($this->p);
            include($this->tplPath);
        }
    }

    /**
     * Get the printed content of the template as return value instead of printing it.
     * @return string - printed contend of template
     */
    function get() {
        ob_start();
        $this->out();
        return ob_get_flush();
    }

    /**
     * Set/Add a variable for the template.
     * @param $variableName string - variable name
     * @param $value * - value of the variable
     */
    function set($variableName, $value) {
        $this->p[$variableName] = $value;
    }

    /**
     * Add a array of variables for the template.
     * @param $array array - variables for the template [varName => value].
     */
    function setArray($array) {
        if(is_array($array)) {
            $this->p = array_merge($this->p, $array);
        }
    }
}