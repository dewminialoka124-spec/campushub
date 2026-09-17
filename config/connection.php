<?php


class Database {

    public static $connection;

    // DB Connection
    public static function setupConnection() {

        if (!isset(Database::$connection)) {
            Database::$connection = new mysqli("localhost", "root", "123dewD!@#A+", "campushub", 3306);
        }
    }

    // INSERT | UPDATE | DELETE
    public static function iud($q) {
        Database::setupConnection();
        Database::$connection->query($q);
    }

    // SELECT
    public static function search($q) {
        Database::setupConnection();
        $resultset = Database::$connection->query($q);
        return $resultset;
    }
}

?>
