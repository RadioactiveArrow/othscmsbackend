<?php
    require 'dbh.php';
    require 'db_manager.php';

    //HTTP inputs
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);
    $id =  $_POST['id'];
    $answer =  $_POST['answer'];

    //looking for matching id
    $sql = "UPDATE clarifications SET answer = ? WHERE id = ?;";
    $output = prepared_sql($sql,[$username, $question, $problem]);
    if($output['success']) {
        $res = $output['res'];
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => true));
    }

    echo "SUCCESS";
