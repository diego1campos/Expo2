<?php
class Database
{
    private static $connection;

    private static function connect()
    {
        $server = 'localhost';
        $database = 'isadeli';
        $username = 'isadeli';
        $password = '123456';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8");
        self::$connection = null;
        try
        {
            self::$connection = new PDO("mysql:host=".$server."; dbname=".$database, $username, $password, $options);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $exception)
        {
            die($exception->getMessage());
        }
    }

    private static function desconnect()
    {
        self::$connection = null;
    }

    public static function executeRow($query, $values)
    {
        self::connect();
        $statement = self::$connection->prepare($query);
        $exito = $statement->execute($values);
        self::desconnect();
        return $exito;
    }

    public static function getRow($query, $values)
    {
        self::connect();
        $statement = self::$connection->prepare($query);
        $statement->execute($values);
        self::desconnect();
        return $statement->fetch(PDO::FETCH_BOTH);
    }

    public static function getRows($query, $values)
    {
        self::connect();
        $statement = self::$connection->prepare($query);
        $statement->execute($values);
        self::desconnect();
        return $statement->fetchAll(PDO::FETCH_BOTH);
    }
}
?>