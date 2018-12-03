<?php
$servername = "127.0.0.1:3306";
$database_username = "Claire_Mayfield";
//$password = PASSWORD GOES HERE
$dbname = "User";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else {
    echo("Connection working!");
}

/*
 * SELECT
 * CREATE
 * DROP <TABLENAME>
 * UPDATE
 * INSERT
 * */

$sql = "INSERT INTO login (username, password) VALUES ('Cmayfield11!', 'Cmay456!')";

if ($conn -> query($sql) === TRUE) {
    echo "\nNew record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn -> error;
}

$conn->close();
?>
