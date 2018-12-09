<!-- Changed the login method so that it is referencing the php in this file. rather than the
code in auth.php. We're looking for a post request and then scanning the txt file. !-->

<?php
session_start();
error_reporting(0);
include("config.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    // Database connection credentials.
    $servername = "127.0.0.1:3306";
    $database_username = "ilmi";
    $password = "Ilmi456!";
    $dbname = "eggfarm";

    // Create connection
    $connection = new mysqli($servername, $database_username, $password, $dbname);
    if ($connection -> connect_error) {
        die("Connection failed: " . $connection -> connect_error);
    } else {
        echo("Connection working!");
    }

    // Lookup user from login table
    $query = "SELECT password FROM login WHERE username = ?";
    $database_password = "";
    echo("Querying database");

    // Preparing and executing the sql statement. Results are bound to $result.
    $sql_statement = $connection -> prepare($query);
    $sql_statement->bind_param("s", $username);
    $sql_statement->execute();
    $sql_statement->bind_result($database_password);
    $sql_statement->fetch();
    $sql_statement->close();

    // If the database's password and the given password match, log the user in.
    if($password == $database_password) {
        echo("You are now logged in, ".$username);
        $_SESSION['username'] = $username;

        $gold = 0;
        $query = "SELECT gold from user_info WHERE username = '$username'";
        $sql_statement = $connection -> prepare($query);
        $sql_statement->bind_param("s", $username);
        $sql_statement->execute();
        $sql_statement->bind_result($gold);
        $sql_statement->fetch();
        $sql_statement->close();
        $_SESSION['gold'] = $gold;

        header("location: HomeScreen.php");
    }
    else {
        echo("Log in failed.");
        return false;
    }
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
