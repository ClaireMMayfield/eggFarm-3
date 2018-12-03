<!-- Php function for registering a new user by adding their username and password to teh
user.txt file. !-->

<?php
session_start();
// Database connection credentials.
$servername = "127.0.0.1:3306";
$username = "ilmi";
$password = "Ilmi456!";
$dbname = "eggfarm";

if(isset($_POST["username"]) && isset($_POST["password"])) {
    $new_username = $_POST["username"];
    $new_password = $_POST["password"];
    //$new_username = "dryoon";
    //$new_password = "Ilmi456!";
    echo("Attempting to create account for ".$new_username." with password: ".$new_password);

    // Create connection
    $connection = new mysqli($servername, $username, $password, $dbname);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    } else {
        echo("Connection working!");
    }

    // Check if username exists already by querying the database for any existing user names.
    $query = "SELECT username FROM login WHERE username = ?";
    $result = "";

    // Preparing and executing the sql statement. Results are bound to $result.
    $sql_statement = $connection->prepare($query);
    $sql_statement->bind_param("s", $new_username);
    $sql_statement->execute();
    $sql_statement->bind_result($result);
    $sql_statement->fetch();
    $sql_statement->close();

    // If the results of the database query are equal to the username, redirect to the login page.
    // Else, create a database entry for the new user. Since the username is a foreign key, we will
    // simultaneously create a database entry for their user info (gold, animals, etc.).
    if ($result == $new_username) {
        echo $new_username . "\r\n";
        echo "is already registered!";
        include 'LoginScreen.html';
        header("Location: LoginScreen.php");
    } else {
        // Creates login database entry with new credentials
        $sql_statement = "INSERT INTO login (username, password) VALUES ('$new_username', '$new_password')";
        if ($connection -> query($sql_statement) === TRUE) {
            echo "\nNew login created successfully";
        } else {
            echo "Error: " . $sql_statement . "<br>" . $connection->error;
        }
        // Creates user_info database entry with 2000 starting gold and 0 animals.
        $sql_statement = "INSERT INTO user_info (username, gold, dino, lizard, chick) VALUES ('$new_username', '2000', '0', '0', '0')";
        if ($connection -> query($sql_statement) === TRUE) {
            echo "\nNew user info entry created successfully";
        } else {
            echo "Error: " . $sql_statement . "<br>" . $connection->error;
        }
    }
    $connection->close();
}
?>
