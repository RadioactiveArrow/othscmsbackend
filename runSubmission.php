<?php

require 'dbh.php';
require 'db_manager.php';


/*
//HTTP inputs
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

$file = $_POST['filePath'];
$name = $_POST['problem'];
$inputPath = "input/".strtolower($name).".in";
copy($inputPath, strtolower(substr($file, 0, strlen($file)-5)).".in");

echo exec("set path=C:\wamp64\www\othscmsbackend\jdk1.8.0_201\bin");
echo exec('javac '.$file." 2>&1");
echo exec('java '.substr($file, 0, strlen($file)-5)." 2>&1");
*/
