<?php
session_start();

if(empty($_SESSION['username'])) {
    header("LOCATION:LoginScreen.php");
}

$username = $_SESSION['username'];

// Calculate top ten scores by iterating through users.txt, getting gold, and sorting it.
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
    // echo("Connection working!");
}

// Querying the database for the top 10 users by gold values.
$query = "SELECT username FROM user_info ORDER BY gold DESC LIMIT 10";
$top_users  = array();
$result = $connection -> query($query);
$rows = resultToArray($result, "username");
$top_users = $rows;

// Querying the database for the top 10 gold values.
$query = "SELECT gold FROM user_info ORDER BY gold DESC LIMIT 10;";
$top_gold  = array();
$result = $connection -> query($query);
$rows = resultToArray($result, "gold");
$top_gold = $rows;

/*
 * Converts the results from the database query into an array
 * by extracting the needed values from the associative array.
 * */
function resultToArray($result, $key) {
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row[$key];
    }
    return $rows;
}

$users_to_json = json_encode((array)$top_users);
$scores_to_json = json_encode((array)$top_gold);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Home Screen</title>
        <style>
            body{
            background-color:lightblue;
            font-family:Courier New;
            }
        </style>
    </head>
    <body>
        <h1>Welcome to your farm, <?php echo($username) ?></h1>
        <p> You have: <?php echo($_SESSION['gold']) ?> gold. </p>
        <p>Here is where you can go to the shop, where you can <br> purchase supplies or eggs, and care for your animals.</p>
        <img src="image014.png" alt = "Red Barn" style = "width:400px;height:400px;""><br>

        <a href="Shop.php">
            <input type="button" value="Go to Shop">
        </a>
        <a href="Your_Barn.php">
            <input type="button" value="Go to your farm">
        </a>

        <h3>Top Ten Scores:</h3>
        <h3 id="scoreboard"></h3>

        <script>
            // Prints the top ten users and their scores. If there are less than ten users,
            // prints the users in order.
            debugger
            var users = <?php echo $users_to_json ?>;
            var scores = <?php echo $scores_to_json ?>;

            let max_size = 10;
            var number_of_users = scores.length;
            if (max_size < number_of_users) {
                size = max_size;
            }
            else {
                size = number_of_users;
            }

            var text = "";

            for(i = 0; i < size; i++)
            {
                let username = users[i];
                let score = scores[i];
                text += "<p>" + (i + 1) + ". " + username + " Score:" + score + "coins</p>";
            }
            document.getElementById("scoreboard").innerHTML = text;
        </script>
    </body>
</html>
