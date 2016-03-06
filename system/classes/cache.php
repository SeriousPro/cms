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
        $encrypted_key = hash(CACHE_KEY_ENCRYPTION, CACHE_SECURITY_SALT.$key);
        // TODO: add $data to cache with $encrypted_key as key and a lifetime of $ttl.
    } /* end Cache::set */

    /**
     * Function for getting data from cache.
     * @param $key string - unencrypted key for cached data
     * @return object|array|string|integer|null - cached data or null
     */
    static function get($key) {
        $encrypted_key = hash(CACHE_KEY_ENCRYPTION, CACHE_SECURITY_SALT.$key);
        // TODO: get and return data from cache with $encrypted_key as key.
        return null;
    } /* end Cache::get */
}