<?php
require 'dbh.php';
require 'db_manager.php';


header("Access-Control-Allow-Headers: *");

//HTTP inputs
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

$team = $_POST['team'];

//looking for matching username
$sql = "SELECT * FROM submissions where user = ?";
$output = prepared_sql($sql, [$team]);
if ($output['success']) {
    $res = $output['res'];
    $response = array('success' => true);
} else {
    $response = array('success' => false);
}

$rows = [];
//checking if password is correct
if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        array_push($rows, $row);
    }
}

echo json_encode($rows);
