<?php
require 'dbh.php';
require 'db_manager.php';

//HTTP inputs
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);
$token = $_POST['authtoken'];
$internal = isset($_POST['action']);

$response = array();

//looking for matching username
$sql = "SELECT * FROM users WHERE auth_token=?";
$output = prepared_sql($sql, [$token]);

//checking if password is correct
if ($output['success']) {
    $res = $output['res'];
    if (mysqli_num_rows($res) == 1) {
        if ($row = mysqli_fetch_assoc($res)) {

            $sql = "SELECT * FROM teams WHERE user_id = ?";
            $output = prepared_sql($sql, [$row['id']]);
            $team = false;

            if($output['success']) {
                $res = $output['res'];
                if(mysqli_num_rows($res) == 1) {
                    if ($team_row = mysqli_fetch_assoc($res)) {
                        $team = array(
                            'member1' => $team_row['member1'],
                            'member2' => $team_row['member2'], 
                            'member3' => $team_row['member3'],
                            'school'  => $team_row['school']
                        );
                    }
                }
            }

            $response = array(
                'authenticated' => true, 
                'auth_key' => $token, 
                'user_id' => $row['id'],
                'admin' => $row['role'] == 'JUDGE', 
                'role' => $row['role'], //TODO remove on switch to new frontend
                'team' => $row['username'], //TODO switch to 'username'
                'team_data' => $team, 
            ); //TODO switch 'team' to username in frontend as well
        }
    } else {
        $response = array('authenticated' => false);
    }
} else {
    $response = array('authenticated' => false);
}

if (!$internal) {
    echo json_encode($response);
} else {
    return $response;
}
