<?php
    require 'dbh.php';
    require 'db_manager.php';


    //HTTP inputs
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);
    $id = $_POST['id'];

    $sql = "DELETE FROM clarifications WHERE id = ?";
    $output = prepared_sql($sql,[$id]);
    if($output['success']) {
        $response = array('success' => true);
    }
    else {
        $response = array('success' => false);
    }    
    $res = $output['res'];

    echo "success";
    die;

    //echo "failure";
    ?>