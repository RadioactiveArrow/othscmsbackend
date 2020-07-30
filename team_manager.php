<?php
require 'dbh.php';
require 'confirm_login.php';

//HTTP inputs
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

$action = $_POST['action'];
$user_id = $response['user_id'];

if ($action == "CREATE" || $action == "UPDATE") {
    $member_1 = $_POST['member1'];
    $member_2 = $_POST['member2'];
    $member_3 = $_POST['member3'];
    $school = $_POST['school'];
}

$response = array();

if (!isset($user_id)) {
    $response = array('success' => false, 'error' => 'Cannot find matching user!');
} else if ($action == "CREATE") { //Creates team
    $sql = "SELECT * FROM teams WHERE user_id=?";
    $output = prepared_sql($sql, [$user_id]);

    if ($output['success']) {
        if (mysqli_num_rows($res) == 1) {
            $response = array('success' => false, 'error' => 'Team already exists!');
        } else {
            $sql = "INSERT INTO teams (user_id, member1, member2, member3, school) VALUES (?, ?, ?, ?, ?)";
            $output = prepared_sql($sql, [$user_id, $member_1, $member_2, $member_3, $school]);

            if ($output['success']) {
                $response = array('success' => true);
            } else {
                $response = array('success' => false, 'error' => $output['error']);
            }
        }
    }
} else if ($action == "READ") { //Gets team data
    $sql = "SELECT * FROM teams WHERE user_id=?";
    $output = prepared_sql($sql, [$user_id]);

    if ($output['success']) {
        $res = $output['res'];
        if (mysqli_num_rows($res) == 1) {
            if ($row = mysqli_fetch_assoc($res)) {
                $response = array('success' => true, 'member1' => $row['member1'], 'member2' => $row['member2'], 'member3' => $row['member3']);
            }
        } else {
            $response = array('success' => false, 'error' => $output['error']);
        }
    } else {
        $response = array('success' => false, 'error' => $output['error']);
    }
} else if ($action == "UPDATE") { //Updates team with new data
    $sql = "SELECT * FROM teams WHERE user_id=?";
    $output = prepared_sql($sql, [$user_id]);

    if ($output['success']) {
        if (mysqli_num_rows($res) == 1) {
            $sql = "UPDATE teams SET member1 = ?, member2 = ?, member3 = ?, school = ? WHERE user_id = ?";
            $output = prepared_sql($sql, [$member_1, $member_2, $member_3, $school, $user_id]);

            if ($output['success']) {
                $response = array('success' => true);
            } else {
                $response = array('success' => false, 'error' => $output['error']);
            }
        } else {
            $response = array('success' => false, 'error' => 'Team does not exist!');
        }
    }
} else if ($action == "DELETE") { //Deletes team
    $sql = "SELECT * FROM teams WHERE user_id=?";
    $output = prepared_sql($sql, [$user_id]);

    if ($output['success']) {
        if (mysqli_num_rows($res) == 1) {
            $sql = "DELETE FROM teams WHERE user_id = ?";
            $output = prepared_sql($sql, [$user_id]);

            if ($output['success']) {
                $response = array('success' => true);
            } else {
                $response = array('success' => false, 'error' => $output['error']);
            }
        } else {
            $response = array('success' => false, 'error' => 'Team does not exist!');
        }
    }
}

echo json_encode($response);
