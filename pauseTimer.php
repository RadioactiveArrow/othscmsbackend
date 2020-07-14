<?php
    require 'dbh.php';


    //HTTP inputs
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);
    $ispreflight = $_POST['ispreflight'];
    if($ispreflight!=3){
      echo "Exiting";
      exit;
    }

    $res = mysqli_query($con, "SELECT * from timer");
    $response = -1;
    if(mysqli_num_rows($res)>0){
        while($row = mysqli_fetch_assoc($res)){
          echo $row['paused'];
          $response = $row['paused'];
        }
    }
    echo (int)$response;
    $newResp = $response;
    if((int)$response==0)$newResp=1;
    else $newResp = 0;
    $sql = "UPDATE timer SET paused = $newResp";
    echo $sql;

    mysqli_query($con, $sql);


    if($newResp==1){
      $now = time();
      $sql = "UPDATE timer SET now = $now";
      mysqli_query($con, $sql);
    }else{
      $set = mysqli_query($con, "SELECT timer from timer")->fetch_object()->timer+(time()-mysqli_query($con, "SELECT now from timer")->fetch_object()->now);
      $sql = "UPDATE timer SET timer = $set";
      mysqli_query($con, $sql);
    }
    exit;

?>
