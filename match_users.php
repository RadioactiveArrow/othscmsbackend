<?php
    require 'dbh.php';
    require 'db_manager.php';


    //HTTP inputs
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);

    $rows = [];
    
    $name = $_POST['name'];
    $team = $_POST['team'];

    if($team != ''){
      //looking for matching username
      $sql = "SELECT * FROM teams where team = \"$team\"";
      $res = mysqli_query($con, $sql);

      if(mysqli_num_rows($res)>0){
        while($row = mysqli_fetch_assoc($res)){
          $info = array("member" => 1, "name" => $row['member1'], "team" => $row['team'], "teamid" => $row['id'], "score" => $row['score1'], "school" => $row['school'],);
          array_push($rows, $info);
          $info = array("member" => 2, "name" => $row['member2'], "team" => $row['team'], "teamid" => $row['id'], "score" => $row['score2'], "school" => $row['school'],);
          array_push($rows, $info);
          $info = array("member" => 3, "name" => $row['member3'], "team" => $row['team'], "teamid" => $row['id'], "score" => $row['score3'], "school" => $row['school'],);
          array_push($rows, $info);
        }
      }

      echo json_encode($rows);
      die;
    }

    if($name == '')die;

    

    //looking for matching username
    $sql = "SELECT * FROM teams where member1 = \"$name\"";
    $res = mysqli_query($con, $sql);


   
    //checking if password is correct
    if(mysqli_num_rows($res)>0){
      while($row = mysqli_fetch_assoc($res)){
        $info = array("member" => 1, "name" => $row['member1'], "team" => $row['team'], "teamid" => $row['id'], "score" => $row['score1'], "school" => $row['school'],);
        array_push($rows, $info);
      }
    }

    //looking for matching username
    $sql = "SELECT * FROM teams where member2 = \"$name\"";
    $res = mysqli_query($con, $sql);


    //checking if password is correct
    if(mysqli_num_rows($res)>0){
      while($row = mysqli_fetch_assoc($res)){
        $info = array("member" => 2, "name" => $row['member2'], "team" => $row['team'], "teamid" => $row['id'], "score" => $row['score2'], "school" => $row['school'],);
        array_push($rows, $info);
      }
    }

    //looking for matching username
    $sql = "SELECT * FROM teams where member3 = \"$name\"";
    $res = mysqli_query($con, $sql);

    //checking if password is correct
    if(mysqli_num_rows($res)>0){
      while($row = mysqli_fetch_assoc($res)){
        $info = array("member" => 3, "name" => $row['member3'], "team" => $row['team'], "teamid" => $row['id'], "score" => $row['score3'], "school" => $row['school'],);
        array_push($rows, $info);
      }
    }

    echo json_encode($rows);
