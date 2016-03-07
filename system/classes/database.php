<?php

/**
 * User: Marcel 'CoNfu5eD Naeve <confu5ed@serious-pro.de>
 * Date: 07.03.2016
 * Time: 17:01
 */

/**
 * Class Database - Database Connection Management
 */
class Database
{
    static $connection = null;

    /**
     * Connect to database if not already connected.
     */
    static function connect() {
        if(Database::$connection == null) {

            $dsn = DATABASE_PDO_DRIVER
                .";host=".DATABASE_HOST
                .";port=".DATABASE_PORT
                .";dbname=".DATABASE_NAME;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
            if(defined('PDO::MYSQL_ATTR_INIT_COMMAND')) {
                $options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES ".DATABASE_CHARSET." COLLATE ".DATABASE_COLLATE;
            } else {
                if(version_compare(PHP_VERSION, '5.3.6', '>=')) {
                    $dsn .= ";charset=" . DATABASE_CHARSET;
                }
            }
            Database::$connection = @new PDO($dsn, DATABASE_USER, DATABASE_PASSWORD);

            if(version_compare(PHP_VERSION, '5.3.6', '<') && !defined('PDO::MYSQL_ATTR_INIT_COMMAND')) {
                Database::$connection->exec(
                    "SET NAMES " . DATABASE_CHARSET
                        . (DATABASE_PDO_DRIVER == "mysql" ? " COLLATE ".DATABASE_COLLATE : "" )
                );
            }

        }
    }

    /**
     * Close database connection if connected.
     */
    static function close() {
        if(Database::$connection != null) {
            Database::$connection->close();
            Database::$connection = null;
        }
    }

    /**
     * Get PDO database connection and connect if not already if connection fails return is null.
     * @return PDO|null
     */
    static function db() {
        Database::connect();
        return Database::$connection;
    }

}