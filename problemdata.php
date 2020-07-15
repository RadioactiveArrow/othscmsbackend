<?php
    require 'dbh.php';
    require 'db_manager.php';


    //HTTP inputs
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);

    $id = $_POST['id'];

    //looking for matching username
    $sql = "SELECT * FROM submissions where id = ?";
    $output = prepared_sql($sql,[$id]);
    if($output['success']) {
        $response = array('success' => true);
    }
    else {
        $response = array('success' => false);
    }     
    $res = $output['res'];
    //checking if password is correct
    if(mysqli_num_rows($res)>0){
      while($row = mysqli_fetch_assoc($res)){

        //$output = shell_exec($row['filePath']);
        //$output = array();
        $file=$row['filePath'];
        exec('javac '.$file);
        exec("java $file", $output);

        $code = file($row['filePath']);

        $response = array('team' => $row['user'], 'filePath' => $row['filePath'], 'systemTime' => $row['systemTime'], 'code' => $code,'output' => $output);
        echo json_encode($response);
        exit;
      }
    }

    echo "No Such Problem Found";
?>
