<?php

$host="localhost"; 

// $root="root"; 
// $password=""; 

$user='root';
$pass='';


$db="flairtales";


    try {
        $dbh = new PDO("mysql:host=$host", $user, $pass);



        // $dbCreate = 'CREATE DATABASE '.$db.'';      // uncomment this line when running for first time


        $TableSchema = "CREATE TABLE IF NOT EXISTS $db.registration ( 
        Registration_Id INT(4) NOT NULL AUTO_INCREMENT , 
        Name VARCHAR(20) NOT NULL , Email VARCHAR(20) NOT NULL ,
        University VARCHAR(20) NOT NULL ,
        Password VARCHAR(164) NOT NULL ,
        Phone_Number BIGINT(20) NOT NULL ,
        PRIMARY KEY (Registration_Id), UNIQUE (Email)) ENGINE = InnoDB";



        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling


        // $dbh->exec($dbCreate)  or die(print_r($dbh->errorInfo(), true));      // uncomment this line when running for first time
       

        $dbh->exec($TableSchema);

           //  if ($createTable) 
           //      {
           //          echo "Table $table - Created!<br /><br />";
           //      }
           //      else 
           //          {
           //           echo "Table $table not successfully created! <br /><br />";
           // }

       
    } catch (PDOException $e) {
        die("DB ERROR: ". $e->getMessage());
    }
?>