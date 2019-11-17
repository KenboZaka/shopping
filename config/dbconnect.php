<?php

try{
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $db_user = 'root';
    $db_password = 'root';
    $dbh = new PDO($dsn, $db_user, $db_password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE. PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
    echo $e->getMessage();
    exit();
}