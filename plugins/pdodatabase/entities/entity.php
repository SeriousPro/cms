<?php

/**
 * User: Marcel 'CoNfu5eD Naeve <confu5ed@serious-pro.de>
 * Date: 20.03.2016
 * Time: 12:26
 */

/**
 * Class Entity
 */
class Entity
{
    var $db = null;
    var $data = null;

    function __construct()
    {
        Database::connect();
        $this->db = &Database::$connection;
    }
}