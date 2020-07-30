<?php
    require 'dbh.php';
    require 'db_manager.php';

    //HTTP inputs
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);
    $username = $_POST['username'];
    $password = $_POST['password'];

    //looking for matching username
    $sql = "SELECT * FROM users WHERE username=\"$username\"";
    $res = mysqli_query($con, $sql);

    //checking if password is correct
    if(mysqli_num_rows($res)>0){
      while($row = mysqli_fetch_assoc($res)){
        if($password == $row['password']){
            $token = bin2hex(random_bytes(64));
            $id = $row['id'];
            $sql = "UPDATE users SET auth_token=\"$token\" WHERE id=$id;";
            $res = mysqli_query($con, $sql);

            $sql = "SELECT * FROM teams WHERE user_id = ?";
            $output = prepared_sql($sql, [$row['id']]);
            $team = false;

            if($output['success']) {
                $res = $output['res'];
                if(mysqli_num_rows($res) == 1) {
                    if ($team_row = mysqli_fetch_assoc($res)) {
                        $team = array(
                            'member1' => $team_row['member1'],
                            'member2' => $team_row['member2'], 
                            'member3' => $team_row['member3'],
                            'school'  => $team_row['school']
                        );
                    }
                }
            }

            $response = array('authenticated' => true, 'auth_key' => $token, 'admin' => $row['role'] == 'JUDGE', 'role' => $row['role'], 'team' => $username, 'team_data' => $team);
            echo json_encode($response);
            exit;
        }
      }
    }

    //authentication failure
    $response = array('authenticated' => false, 'error' => 'Login Failure: Username or Password may be incorrect.');
    echo json_encode($response);
?>
