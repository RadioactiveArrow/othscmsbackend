<?php
    require 'dbh.php';


    $problem = $_POST['problem'];
    $team = $_POST['team'];
    
    $filename = $_FILES['file']['name'];
    //Stores the filetype e.g image/jpeg
    $filetype = $_FILES['file']['type'];
    //Stores any error codes from the upload.
    $fileerror = $_FILES['file']['error'];
    //Stores the tempname as it is given by the host when uploaded.
    $filetemp = $_FILES['file']['tmp_name'];

    //The path you wish to upload the file to
    $filePath = "submissions/" . $team . "/";

    
    //separating by problem
    if (!is_dir($filePath.$problem)) 
    mkdir($filePath.$problem, 0700);

    $filePath = $filePath . $problem . "/";




    if(is_uploaded_file($filetemp)) {
        
        //date for separating attempts
        $date = date('Y-m-d-H-i-s');
        mkdir($filePath.$date, 0700);

        $filePath = $filePath . $date . "/";

        if(move_uploaded_file($filetemp, $filePath . $filename)) {

            $filePath = $filePath . $filename;
            
            $sql = "INSERT INTO submissions (user, problemName, filePath) VALUES (\"$team\", \"$problem\", \"$filePath\")";
            $res = mysqli_query($con, $sql);

            echo "Sussecfully uploaded your image.";
        }
        else {
            echo "Failed to move your image.";
        }
    }
    else {
        echo "Failed to upload your image.";
    }
    
?>
