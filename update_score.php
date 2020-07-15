<?php
    require 'dbh.php';
    require 'db_manager.php';


    //HTTP inputs
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);
    $id =  $_POST['id'];
    $member = $_POST['member'];
    $score = $_POST['score'];

    if($member == 1){
        //update school
        $sql = "UPDATE teams SET score1 = $score where id = $id";
        $res = mysqli_query($con, $sql);
    }
    if($member == 2){
        //update school
        $sql = "UPDATE teams SET score2 = $score where id = $id";
        $res = mysqli_query($con, $sql);
    }
    if($member == 3){
        //update school
        $sql = "UPDATE teams SET score3 = $score where id = $id";
        $res = mysqli_query($con, $sql);
    }

    echo "success";
    
    ?>