<?php
    require 'dbh.php';
    require 'db_manager.php';

    //HTTP inputs
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);
    $problem =  $_POST['problem'];
    $append = $_POST['append'];

    if($append){
        //looking for matching ptoblem
        $sql = "INSERT INTO problems (problem) VALUES (?)";
        $output = prepared_sql($sql,[$problem]);
        if($output['success']) {
            $res = $output['res'];
            $response = array('success' => true);
        }
        else {
            $response = array('success' => false);
        }        
    }
    else{
        //looking for matching problem
        $sql = "DELETE FROM problems WHERE problem = ?";
        $output = prepared_sql($sql,[$problem]);
        if($output['success']) {
            $response = array('success' => true);
        }
        else {
            $response = array('success' => false);
        }      
    }
    echo $response;
