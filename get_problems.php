<?php
    require 'dbh.php';
    require 'db_manager.php';


    //looking for matching username
    $sql = "SELECT * FROM problems";
    $res = mysqli_query($con, $sql);


    $rows = [];
    //checking if password is correct
    if(mysqli_num_rows($res)>0){
      while($row = mysqli_fetch_assoc($res)){
        array_push($rows, $row);
      }
    }

    echo json_encode($rows);
?>
