<?php
require 'dbh.php';
require 'db_manager.php';

//HTTP inputs
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);
$token = $_POST['authtoken'];

//looking for matching username
$sql = "SELECT * FROM users WHERE auth_token=?";
$output = prepared_sql($sql, [$token]);

//checking if password is correct
if ($output['success']) {
    $res = $output['res'];
    if (mysqli_num_rows($res) == 1) {
        if ($row = mysqli_fetch_assoc($res)) {
            $response = array('authenticated' => true, 'auth_key' => $token, 'admin' => $row['role'] == 'JUDGE', 'role' => $row['role'], 'team' => $row['username']);
            echo json_encode($response);
        }
    } else {
        $response = array('authenticated' => false);
        echo json_encode($response);
    }
} else {
    $response = array('authenticated' => false);
    echo json_encode($output);
}
