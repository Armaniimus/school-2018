<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $database = "cruddatabase";
//
// try {
//     $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     $sql = "create Database myDBPFO";
//     $conn->exec($sql);
//
//         echo "Connected successfully";
//     }
// catch(PDOException $e)
//     {
//     echo "Connection failed: " . $e->getMessage();
//     }


$servername = "localhost";
$username = "root";
$password = "";
$database = "myDBPFO";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $sql = "create Database myDBPFO";
    // $conn->exec($sql);

        echo "Connected successfully";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }








?>
