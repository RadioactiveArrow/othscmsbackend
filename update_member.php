<?php
    require 'dbh.php';
    require 'db_manager.php';


    //HTTP inputs
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);
    $team =  $_POST['team'];
    $member = $_POST['member'];
    $index = $_POST['index'];

    if($member != ""){
        if($index == 1){
            $sql = "UPDATE teams SET member1 = ? where team =?";
        }
        else if($index == 2){
            $sql = "UPDATE teams SET member2 = ? where team = ?";
        }
        else if($index == 3){
            $sql = "UPDATE teams SET member3 = ? where team = ?";
        }
        $output = prepared_sql($sql,[$team,$member,$index]);
        if($output['success']) {
            $response = array('success' => true);
        }
        else {
            $response = array('success' => false);
        }        $res = $output['res'];
    }

    //update school
    $sql = "SELECT * from teams where team = ?";
    $output = prepared_sql($sql,[$team]);
    if($output['success']) {
        $response = array('success' => true);
    }
    else {
        $response = array('success' => false);
    }        $res = $output['res'];

    //checking if password is correct
    if(mysqli_num_rows($res)>0){
        while($row = mysqli_fetch_assoc($res)){
            if($index == 1){echo $row['member1'];}
            else if($index == 2){echo $row['member2'];}
            else if($index == 3){echo $row['member3'];}
        }
      }
    
    die;

    ?>