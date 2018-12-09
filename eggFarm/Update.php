<?php
session_start();

// Database connection credentials.
$servername = "127.0.0.1:3306";
$database_username = "ilmi";
$password = "Ilmi456!";
$dbname = "eggfarm";

// Create connection
$connection = new mysqli($servername, $database_username, $password, $dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} else {
    echo("Connection working!");
}

// Getting possible new values from the $_REQUEST dictionary.
$username = $_SESSION['username'];
$inquiry = htmlspecialchars($_REQUEST['inquiry']);
$gold = (int) htmlspecialchars($_REQUEST['gold']);
$animal_name = htmlspecialchars($_REQUEST['animal_name']);
$animal_name = str_replace("'", "", $animal_name);

echo("Gold is: ".$_REQUEST['gold']);
echo("Animal is: ".$animal_name);

// Updates the gold if a new gold is given.
if (!empty($_REQUEST['gold'])) {
    $gold = $_REQUEST['gold'];
    $sql_statement = "UPDATE user_info SET gold = '$gold' WHERE username = '$username'";
    if ($connection -> query($sql_statement) === TRUE) {
        echo "\nSuccessfully updated gold for ".$username." to ".$gold;
    } else {
        echo "Error: " . $sql_statement . "<br>" . $connection->error;
    }
    $_SESSION['gold'] = $gold;
}

// Increments the animal by one if an animal name is given.
if(!empty($_REQUEST['animal_name'])) {
    // Finds the existing value for the animal entry.
    $query = "SELECT $animal_name FROM user_info WHERE username = ?";
    $result = "";

    // Preparing and executing the sql statement. Results are bound to $result.
    $sql_statement = $connection->prepare($query);
    $sql_statement->bind_param("s", $username);
    $sql_statement->execute();
    $sql_statement->bind_result($result);
    $sql_statement->fetch();
    $sql_statement->close();
    // Increments the number of animals for the given animal type.
    $result = (int) $result + 1;

    // Update the database with the new incremented value.
    $sql_statement = "UPDATE user_info SET $animal_name = '$result' WHERE username = '$username'";
    if ($connection -> query($sql_statement) === TRUE) {
        echo "\nSuccessfully updated animal count for ".$username."'s ".$animal_name." to ".$result;
    } else {
        echo "Error: " . $sql_statement . "<br>" . $connection->error;
    }
}