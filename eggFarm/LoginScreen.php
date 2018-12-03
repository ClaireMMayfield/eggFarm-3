<!-- Changed the login method so that it is referencing the php in this file. rather than the
code in auth.php. We're looking for a post request and then scanning the txt file. !-->

<?php
session_start();
error_reporting(0);
include("config.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    $userfile = fopen("user.txt", "r") or die("Unable to open user file:".$username);
    $tmp_arry = [];
    while(!feof($userfile)){
        $line = trim(fgets($userfile));
        $tmp_arry = explode(":", $line);
        if(!count($tmp_arry)==2){
            continue;
        }
        if($tmp_arry[0] ==$username and $tmp_arry[1]==$password)
        {
            echo("You are now logged in, ".$username);
            $_SESSION['username'] = $username;
            header("location: HomeScreen.php");
        }
    }
    echo("Log in failed.");
    return false;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Screen</title>
    <style>
    body{
        background-color:lightblue;
        font-family:Courier New;
        }

    </style>
</head>
    <body>
        <h1>
            Welcome to the Egg Farm!
        </h1>
        <h3>You will receive 5 gold coins per play.</h3>
        <form name="form" action="" onsubmit="" method="post">
            Enter your name: <br>
            <input type="text" name="username"><br>
            Enter your password:<br>
            <input type="password" name="password">
            <input type="submit" value="Submit">
        </form>

        <img src = "image014.png" alt = "Red Barn" style = "width:400px; height:400px;">
        <h2>Don't have an account? Sign up here!</h2>
        <a href="RegistrationPage.php">
            <input type="submit" value="Sign Up">
        </a>
    </body>
</html>
