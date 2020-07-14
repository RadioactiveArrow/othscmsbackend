<?php
    require 'dbh.php';

    //HTTP inputs
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);
    $id =  $_POST['id'];
    $answer =  $_POST['answer'];

    //looking for matching id
    $sql = 
    "UPDATE clarifications
    SET answer = \"$answer\"
    WHERE id = \"$id\";";

    $res = mysqli_query($con, $sql);


    echo "SUCCESS";
?>
