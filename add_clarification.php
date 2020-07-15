<?php
    require 'dbh.php';
    require 'db_manager.php';

    //HTTP inputs
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);

    $username =  $_POST['team'];
    $question =  $_POST['question'];
    $problem = $_POST['problem'];

    if(isset($question)){
        //insert to database
        $sql = "INSERT INTO clarifications (team, question, problem) VALUES (?, ?, ?)";
        $output = prepared_sql($sql,[$username, $question, $problem]);
        if($output['success']) {
            $response = array('success' => true);
        }
        else {
            $response = array('success' => false);
        }
    die;
    }

    echo json_encode($response);
