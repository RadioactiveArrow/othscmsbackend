<?php
    require 'dbh.php';


    //HTTP inputs
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);

    $sql = "SELECT * from timer";
    $res = mysqli_query($con, $sql);
    if(mysqli_num_rows($res)>0){
        while($row = mysqli_fetch_assoc($res)){
            if($row['paused']==1){

              $newval = $row['timer']-$row['now'];
            }else{
              $newval = $row['timer']-time();
            }
            $response = $newval;
            if($response<0){
              $response = 0;
            }

            echo json_encode($response);
            exit;
        }
    }
    echo json_encode($response);
?>
