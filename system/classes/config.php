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
     * @return string|int|float|null|array value to the $key.
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
     * Prepares data for writing into config file.
     * @param $data * - data for writing into config
     * @return string ready to write data
     */
    static function prepareData($data) {
        if(is_numeric($data)) return $data;
        if(is_string($data)) return '"'.$data.'"';
        if(is_bool($data)) return ($data ? 'true' : 'false');
        return null;
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
            if(is_array($value) && max(array_map('count', $value)) == 1) {
                /* array with depth of 1: */
                fwrite($fh, '$value = [];'."\n");
                foreach($value as $k => $v) {
                    fwrite($fh, '$value['.$k.'] = '.Config::prepareData($v).';'."\n");
                }

            } else {
                $data = Config::prepareData($value);
                if($data) {
                    fwrite($fh, '$value = '."$data;\n");
                } else {
                    throw new Exception("Not Supported Config Value");
                }

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