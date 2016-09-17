<?php
	$host = 'localhost';
    $username = 'isadeli';
    $password = '123456';
    $database = 'isadeli';
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8");
    try
    {
        $PDO = new PDO("mysql:host=".$host."; dbname=".$database, $username, $password,$options);
    }
    catch(PDOException $e)
    {
        die($e->getMessage());
    }
?>