<?php

/**
 * User: Marcel 'CoNfu5eD Naeve <confu5ed@serious-pro.de>
 * Date: 14.03.2016
 * Time: 02:41
 */

/**
 * Class Config - Handle Configuration
 */
class Config
{

    /**
     * Get value from configuration file.
     * @param $key string - name of the file
     * @return string|int|float|null value to the $key.
     */
    static function get($key) {
        $value = null;
        $requested_file = __CONFIGS_DIR__ . "/$key.php";

        /* load config if exist */
        if(file_exists($requested_file)) {
            include $requested_file;
        }

        return $value;
    }

    /**
     * Set value to configuration file.
     * @param $key string - name of the file
     * @param $value string|int|float|null - configuration value
     * @return bool success?
     */
    static function set($key, $value) {
        $requested_file = __CONFIGS_DIR__ . "/$key.php";

        /* write to config */
        try {
            $fh = fopen($requested_file, "w");
            fwrite($fh, "<?php\n");
            if (is_numeric($value)) {
                fwrite($fh, '$value = ' . "$value;\n");
            } else {
                fwrite($fh, '$value = ' . "'$value';\n");
            }
            fclose($fh);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * Alias function for Config::set.
     * @param $key string - name of the file
     * @param $value string|int|float|null - configuration value
     * @return bool success?
     */
    static function put($key, $value) {
        return Config::set($key, $value);
    }

    /**
     *
     * @param $name
     * @param $arguments
     * @return bool|null
     */
    static function __callStatic($name, $arguments)
    {
        /* prepare function name */
        $f = mb_strtolower($name);
        $fn = mb_substr($f, 0, 3);
        $fr = mb_substr($f, 2, mb_strlen($f)-3);

        /* choose function by function prefix */
        switch($fn) {
            case "get":
                return Config::get($fr);
                break;
            case "set":
                return Config::set($fr, $arguments[0]);
                break;
            default: return null;
        }
    }

}