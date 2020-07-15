<?php
    require 'dbh.php';
    require 'db_manager.php';


    //HTTP inputs
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);
    $id = $_POST['id'];

    $sql = "DELETE FROM clarifications WHERE id = \"$id\"";
    $res = mysqli_query($con, $sql);

    echo "success";
    die;

    //echo "failure";
    ?>