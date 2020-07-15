<?php
    require 'dbh.php';
    require 'db_manager.php';


    //HTTP inputs
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);
    $username =  $_POST['username'];
    $password =  $_POST['password'];
    $role = $_POST['role'];
    $append = $_POST['append'];

    if (!is_dir('submissions')){
        mkdir("submissions", 0700);
    }

    if($append){
        
        //looking for matching user
        $sql = "INSERT INTO users (username, password, role) VALUES (?,?,?)";
        $output = prepared_sql($sql,[$username,$password,$role]);
        if($output['success']) {
            $response = array('success' => true);
        }
        else {
            $response = array('success' => false);
        }    
        $res = $output['res'];


        if($role == "COMPETITOR"){
            $sql = "INSERT INTO teams (team) VALUES (?)";
            $output = prepared_sql($sql,[$team]);
            if($output['success']) {
                $response = array('success' => true);
            }
            else {
                $response = array('success' => false);
            }    
            $res = $output['res'];
        }


        if (!is_dir('submissions/'.$username) && $role == 'COMPETITOR') 
            mkdir("submissions/".$username, 0700);
        echo "success";
        die;
    }
    //checks if this is not a preflight request
    else if ($username != ""){
        //looking for matching user
        $sql = "DELETE FROM users WHERE username = ?";
        $output = prepared_sql($sql,[$username]);
        if($output['success']) {
            $response = array('success' => true);
        }
        else {
            $response = array('success' => false);
        }    
        $res = $output['res'];        

    // /////////////////////////////////////////////////////

        $sql = "DELETE FROM teams WHERE team = ?";
        $output = prepared_sql($sql,[$teams]);
        if($output['success']) {
            $response = array('success' => true);
        }
        else {
            $response = array('success' => false);
        }    
        $res = $output['res'];
        // /////////////////////////////////////////////////////

        $sql = "DELETE FROM submissions WHERE user = ?";
        $output = prepared_sql($sql,[$user]);
        if($output['success']) {
            $response = array('success' => true);
        }
        else {
            $response = array('success' => false);
        }    
        $res = $output['res'];




        if (is_dir('submissions/'.$username))
            rmdir_recursive('submissions/'.$username.'/');
        echo "success";
        die;
    }

    echo "failure";

    //recursively removes all directories
    function rmdir_recursive($dir) {
        foreach(scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
            else unlink("$dir/$file");
        }
        rmdir($dir);
    }

    ?>