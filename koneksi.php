<?php
 try{
     $conn = new \PDO('sqlite:./database.db');
 }catch(\PDOException $e){
     echo $e->getMessage();
 }
 
include 'database.php';
 