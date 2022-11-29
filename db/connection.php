<?php

function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'sir-crud';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' 
        . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } 
    catch (PDOException $exception) 
    {
        exit('Failed to connect to database!');
    }
}
?>