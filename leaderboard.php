<?php
  require 'dbh.php';
  require 'db_manager.php';



  class Team{
    public $school;
    public $score;
    public $team;
    public function __construct($school, $score, $team){
      $this->school = $school;
      $this->score = $score;
      $this->team = $team;
    }
  }

  //HTTP inputs
  $rest_json = file_get_contents("php://input");
  $_POST = json_decode($rest_json, true);

  //looking for matching username
  $sql = "SELECT * FROM teams";
  $res = mysqli_query($con, $sql);
  $teams = array();
  if(mysqli_num_rows($res)>0){
    while($row = mysqli_fetch_assoc($res)){

      //collecting all problem submissions from team
      $team_id = $row['team'];
      $sql_team = "SELECT * FROM submissions WHERE user=\"$team_id\"";
      $prob = mysqli_query($con, $sql_team);

      if(mysqli_num_rows($prob)>0){
        $completed = array();
        $score = 0;
        while($problem = mysqli_fetch_assoc($prob)){

          //team that completed problem
          $t = $problem["user"];

          //if the team doesn't exist in scores, add score = 0
          if(!array_key_exists("$t", $teams))$teams["$t"] = 0;

          //if status is completed and problem not already added to list
          if($problem["status"]=="COMPLETED"&&!in_array($problem["problemName"],$completed)){
            
            //add problem to list and calculate score
            $completed[] = $problem["problemName"];
            $pID = $problem["problemName"];
            $sql_team = "SELECT * FROM submissions WHERE user=\"$team_id\" AND problemName=\"$pID\"";
            $attempts = mysqli_query($con, $sql_team);
            $score = 60;

            //deduct points for failed attempts
            if(mysqli_num_rows($attempts)>0){
              while($att = mysqli_fetch_assoc($attempts)){
                if($att["status"]=="FAILED")$score -= 5;
              }
            }

            //add points to overall score
            $teams["$t"] += $score;
          }
        }
      }else{
        //prevent nonexistant indices
        $teams["$team_id"] = 0;
      }
    }
    $schools = array();

    //increments i for id adds Team object into schools array
    
    $sql = "SELECT * FROM teams";
    $res = mysqli_query($con, $sql);
    if(mysqli_num_rows($res)>0){
      while($result = mysqli_fetch_assoc($res)){
        $i = $result["team"];
        $schools[$i] = new Team($result["school"], $teams["$i"], $i);
      }
    }
    

    //json encode schools
    echo json_encode($schools);
  }


?>
