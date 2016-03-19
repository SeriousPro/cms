<?php

/**
 * User: Marcel 'CoNfu5eD Naeve <confu5ed@serious-pro.de>
 * Date: 07.03.2016
 * Time: 00:25
 */

/**
 * Class Cache - Cache Management
 */
class Cache
{

    /**
     * @param $key string - unencrypted key for data in cache
     * @param $data object|array|string|integer - data which have to be cached
     * @param $ttl integer - time to life
     */
    static function set($key, $data, $ttl) {
        $encrypted_key = hash(Config::get("cache_key_encryption"), Config::get("cache_security_salt").$key);

        return self::putToCache($encrypted_key, $data, $ttl);
    } /* end Cache::set */

    /**
     * Function for getting data from cache.
     * @param $key string - unencrypted key for cached data
     * @return object|array|string|integer|null - cached data or null
     */
    static function get($key) {
        $encrypted_key = hash(Config::get("cache_key_encryption"), Config::get("cache_security_salt").$key);

        return self::getFromCache($encrypted_key);
    } /* end Cache::get */


    static function putToCache($ek, $data, $ttl) {
        $index_file = Config::get("cache_directory") . "/index/" . $ek . ".php";
        $data_file = Config::get("cache_directory") . "/data/" . $ek . ".php";

        if(file_exists($index_file)) {
            unlink($index_file);
        }
        $index_success = file_put_contents($index_file, '$ttl = '.(time()+$ttl).';');

        if(file_exists($data_file)) {
            unlink($data_file);
        }
        $data_success = file_put_contents($data_file, '$data = "'.json_encode($data).'";'."\n");

        if($index_success && $data_success) return true;
        return false;
    }

    static  function getFromCache($ek) {
        $index_file = Config::get("cache_directory") . "/" . Config::get("cache_index_directory") . "/" . $ek . ".php";
        $data_file = Config::get("cache_directory") . "/" . Config::get("cache_data_directory") . "/" . $ek . ".php";

        if(!(file_exists($index_file) && file_exists($data_file))) return null;

        $ttl = 0;
        include $index_file;
        if($ttl-time() <= 0) {
            @unlink($index_file);
            @unlink($data_file);
            return null;
        }

        $data = null;
        include $data_file;
        if($data)
            return json_decode($data);

        return null;
    }
}
