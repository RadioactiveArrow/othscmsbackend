<?php
require 'dbh.php';
require 'db_manager.php';


//HTTP inputs
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);
$id =  $_POST['id'];
$member = $_POST['member'];
$score = $_POST['score'];

if ($member == 1) {
    //update score
    $sql = "UPDATE teams SET score1 = $score where id = ?";
    $output = prepared_sql($sql, [$member, $score]);
    if ($output['success']) {
        $res = $output['res'];
        $response = array('success' => true);
    } else {
        $response = array('success' => false);
    }
}
if ($member == 2) {
    //update score
    $sql = "UPDATE teams SET score2 = $score where id = ?";
    $output = prepared_sql($sql, [$member, $score]);
    if ($output['success']) {
        $res = $output['res'];
        $response = array('success' => true);
    } else {
        $response = array('success' => false);
    }
}
if ($member == 3) {
    //update score
    $sql = "UPDATE teams SET score3 = $score where id = ?";
    $output = prepared_sql($sql, [$member, $score]);
    if ($output['success']) {
        $res = $output['res'];
        $response = array('success' => true);
    } else {
        $response = array('success' => false);
    }
}

echo $response;
