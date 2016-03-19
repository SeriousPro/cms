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
    /**
     * @var PDO
     */
    static $connection = null;

    /**
     * Connect to database if not already connected.
     */
    static function connect() {
        if(Database::$connection == null) {

            $dsn = Config::get("database_driver")
                .";host=".Config::get("database_host")
                .";port=".Config::get("database_port")
                .";dbname=".Config::get("database_dbname");
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
            if(defined('PDO::MYSQL_ATTR_INIT_COMMAND')) {
                $options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES ".Config::get("database_charset")." COLLATE ".Config::get("database_collate");
            } else {
                if(version_compare(PHP_VERSION, '5.3.6', '>=')) {
                    $dsn .= ";charset=" . Config::get("database_charset");
                }
            }
            Database::$connection = @new PDO($dsn, Config::get("database_user"), Config::get("database_password"));

            if(version_compare(PHP_VERSION, '5.3.6', '<') && !defined('PDO::MYSQL_ATTR_INIT_COMMAND')) {
                Database::$connection->exec(
                    "SET NAMES " . Config::get("database_charset")
                        . (Config::get("database_driver") == "mysql" ? " COLLATE ".Config::get("database_collate") : "" )
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