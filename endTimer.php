<?php
    require 'dbh.php';

    //HTTP inputs
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);
    $time = 0;
    $sql = "UPDATE timer SET timer = $time";

    $res = mysqli_query($con, $sql);
    echo "SUCCESS";
