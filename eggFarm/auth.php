<?php
function auth($username, $password){
    $userfile = fopen("user.txt", "r") or die("Unable to open user file:".$username);
    $tmp_arry = [];
    while(!feof($userfile)){
        $line = trim(fgets($userfile));
        $tmp_arry = explode(":", $line);
        if(!count($tmp_arry)==2){
            continue;
        }
        if($tmp_arry[0] ==$username and $tmp_arry[1]==$password)
            echo("You are now logged in, ".$username);
            header("location: your_farm.php");
    }
    echo("Log in failed.");
    return false;
}
