<?php
    require 'dbh.php';

    //HTTP inputs
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);

    $username =  $_POST['team'];
    $question =  $_POST['question'];
    $problem = $_POST['problem'];

    //Escapes vars
    $username = mysqli_real_escape_string($con, $username);
    $question = mysqli_real_escape_string($con, $question);
    $problem = mysqli_real_escape_string($con, $problem);

    if(isset($question)){
        //insert to database
        $sql = "INSERT INTO clarifications (team, question, problem) VALUES (\"$username\", \"$question\", \"$problem\")";
        $res = mysqli_query($con, $sql);
        echo "success";    
    die;
    }

    echo "failure";
    ?>