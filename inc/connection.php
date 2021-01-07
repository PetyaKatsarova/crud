<?php
try{
    // $db = new PDO("sqlite:".__DIR__."/database.db");
    $db = new PDO("mysql:host=localhost;dbname=crud;port=3306", "root");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
    echo $e->getMessage();
    exit;
}
// var_dump($db);