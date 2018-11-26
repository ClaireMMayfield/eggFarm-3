<?php
session_start();

$gold = htmlspecialchars($_REQUEST['gold']);
$animal_name = htmlspecialchars($_REQUEST['animal']);
$check = htmlspecialchars($_REQUEST['inquiry']);
$filename = $_SESSION['username']."_data.txt";
$myfile = fopen($filename, "r+") or die("Unable to open file!");
$data = array();
while(!feof($myfile)) {
    $line = fgets($myfile);
    $tmp_arry = explode(":", $line);
    if(count($tmp_arry) == 1)
        continue;
    $data[$tmp_arry[0]] = $tmp_arry[1];
    error_log($tmp_arry[0] . "..".$tmp_arry[1]);
}

if(!empty($gold)) {
    $data['gold'] = $gold;
    error_log("gold:".$gold);
}

if(!empty($animal_name)) {
    $data[$animal_name] += 1;
    error_log("animal:".$data['animal']."Received:".$animal_name);
} else
    $data[$animal_name] = 1;
$cTime = time();
$diff = ($cTime - $data['last_updated'])/100;

if($diff > 3600*1000)
    $diff = 0;

if($diff > 1) {
    $earning = ($data['dino'] + $data['lizard'] + $data['chick']) * round($diff);
    $msd = "Diff: " . $diff . " Earning:" . $earning;
    $data['gold'] += $earning;
}

if(!empty($check) and $check=='gold') {
    echo $data['gold'];
    error_log("Inquiry for gold is called:".$data['gold']);
}
writeToFile($data);

/*
 * Updates the user's data file by rewriting the entire file
 * with updated values. Creates entry for each animal if that entry is missing.
 * */
function writeToFile($data) {
    if(empty($data['dino']))
        $data['dino'] = 0;
    if(empty($data['chick']))
        $data['chick'] = 0;
    if(empty($data['lizard']))
        $data['lizard'] = 0;
    $filename = $_SESSION['username']."_data.txt";
    $myFile = fopen($filename, "r+") or die("Unable to open file!");

    $gold = str_replace("'", "", $data['gold']);

    fwrite($myFile, "name:".$data['name']);
    fwrite($myFile, "gold:".$gold);
    fwrite($myFile, "\n"."dino:".$data['dino']);
    fwrite($myFile, "\n"."chick:".$data['chick']);
    fwrite($myFile, "\n"."lizard:".$data['lizard']);
}

// Update session variables to hold new gold value after writing.
$_SESSION['gold'] = $gold;