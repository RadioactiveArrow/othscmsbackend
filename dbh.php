<?php

//CORS Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$servername = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "othscmsdb";

$con = mysqli_connect($servername, $dbUser, $dbPass, $dbName);

if(!$con) {
    die("Connection Error: ".mysqli_connect_error());
}