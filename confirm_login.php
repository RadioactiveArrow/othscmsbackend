<?php
    require 'dbh.php';

    //HTTP inputs
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);
    $token = $_POST['authtoken'];

    //looking for matching username
    $sql = "SELECT * FROM users WHERE auth_token=\"$token\"";
    $res = mysqli_query($con, $sql);

    //checking if password is correct
    if(mysqli_num_rows($res) == 1){
        if ($row = mysqli_fetch_assoc($res)){
            $response = array('authenticated' => true, 'auth_key' => $token, 'admin' => $row['role'] == 'JUDGE', 'role' => $row['role'], 'team' => $row['username']);
            echo json_encode($response);
            exit;
        }
    }

    $response = array('authenticated' => false);
    echo json_encode($response);

?>