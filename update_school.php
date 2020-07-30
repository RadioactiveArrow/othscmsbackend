<?php
require 'dbh.php';
require 'db_manager.php';


//HTTP inputs
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);
$team =  $_POST['team'];
$school = $_POST['school'];

if ($school != "") {
    //update school
    $sql = "UPDATE teams SET school = ? where team = ?";
    $output = prepared_sql($sql, [$team, $school]);
    if ($output['success']) {
        $res = $output['res'];
        $response = array('success' => true);
    } else {
        $response = array('success' => false);
    }
}

//update school
$sql = "SELECT * from teams where team = ?";
$output = prepared_sql($sql, [$team]);
if ($output['success']) {
    $response = array('success' => true);
    $res = $output['res'];
    //checking if password is correct
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            echo $row['school'];
        }
    }
} else {
    $response = array('success' => false);
}

die;
