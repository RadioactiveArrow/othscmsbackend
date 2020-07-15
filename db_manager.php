<?php

function prepared_sql($sql, $vars) {
    require 'dbh.php';

    $output = array();
    $bindStr = "";
    $stmt = mysqli_stmt_init($con);

    //Creates bind string from $vars
    foreach ($vars as $val) { 
        if (is_int($val)) {
            $bindStr .= "i";
        } elseif (is_double($val)) {
            $bindStr .= "d";
        } elseif (is_string($val)) {
            $bindStr .= "s";
        } 
    }

    if(substr_count($sql, '?') != count($vars)) {
        $output['success'] = false;
        $output['error'] = "Number of '?' in SQL statement != Number of variables in list! (".substr_count($sql, '?')." != ".count($vars).")";
    }
    elseif(mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, $bindStr, ...$vars);
        mysqli_stmt_execute($stmt);
        $output['success'] = true;
        $output['res'] = mysqli_stmt_get_result($stmt);
    } else {
        $output['success'] = false;
        $output['error'] = "SQL statement syntax was bad!";
    }
    return $output;
}


// $sql = "SELECT * FROM tests WHERE testID=? LIMIT 1";
// $stmt = mysqli_stmt_init($con);
// if(mysqli_stmt_prepare($stmt, $sql)) {
//     mysqli_stmt_bind_param($stmt, "i", $_POST['test']);
//     mysqli_stmt_execute($stmt);
//     $result = mysqli_stmt_get_result($stmt);
//     if ($r = mysqli_fetch_assoc($result)) {
//         $var = $r['table_column'];
//     }
// }
