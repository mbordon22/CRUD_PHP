<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "pruebacrud";

$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_error){
    die($error->$conn->connect_error);
}

?>