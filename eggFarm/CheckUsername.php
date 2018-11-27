<?php
session_start();

$username_to_test = $_REQUEST['username'];

$file_name = "user.txt";
$users_file = fopen($file_name, "r") or die("Unable to open file");
$users = [];
$tmp_arry = [];
$size = 0;
while(!feof($users_file)){
    $line = trim(fgets($users_file));
    $tmp_arry = explode(":", $line);
    if(!count($tmp_arry)==2){
        continue;
    }
    array_push($users, $tmp_arry[0]);
    $size = count($users) - 1;
}

$name_is_okay = false;

// Return true if the name already exists. Returns false otherwise.
if (in_array($username_to_test, $users)) {
    $name_is_okay = false;
}
else {
    $name_is_okay = true;
}

$_SESSION['name_check'] = $name_is_okay;
