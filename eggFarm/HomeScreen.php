<?php
session_start();

if(empty($_SESSION['username'])) {
    header("LOCATION:LoginScreen.php");
}

$username = $_SESSION['username'];

// Get gold and save it to the session.
$file_name = $username . "_data.txt";
$user_data = fopen($file_name, "r") or die("Unable to open file");
$tmp_arry = [];
while(!feof($user_data)){
    $line = trim(fgets($user_data));
    $tmp_arry = explode(":", $line);
    if(!count($tmp_arry)==2){
        continue;
    }
    if($tmp_arry[0] == "gold")
    {
        $gold = $tmp_arry[1];
        $_SESSION['gold'] = $gold;
    }
}


// Calculate top ten scores by iterating through users.txt, getting gold, and sorting it.

// Gets all users.
$file_name = "user.txt";
$userfile = fopen($file_name, "r") or die("Unable to open file");
$users = [];
$tmp_arry = [];
$size = 0;
while(!feof($userfile)){
    $line = trim(fgets($userfile));
    $tmp_arry = explode(":", $line);
    if(!count($tmp_arry)==2){
        continue;
    }
    array_push($users, $tmp_arry[0]);
    $size = count($users) - 1;
}

$scores = [];
$i = 0;
// Get scores of all users, store top 10.
while($i < $size) {
    $temp_username = $users[$i];
    $file_name = $temp_username."_data.txt";
    $user_data_file = fopen($file_name, "r") or die("Unable to open file");
    while(!feof($user_data_file)){
        $line = trim(fgets($user_data_file));
        $tmp_arry = explode(":", $line);
        if(!count($tmp_arry)==2){
            continue;
        }
        // If we found a gold value, push the value onto the scores array.
        if($tmp_arry[0] == "gold")
        {
            $score = $tmp_arry[1];
            array_push($scores, $score);
        }
    }
    $i++;
}

// Sort scores and users simultaneously.
for($i = 0; $i < count($scores); $i++){
    $score_value = $scores[$i];
    $user_value = $users[$i];
    $j = $i - 1;
    while($j >= 0 && $scores[$j] < $score_value){
        $scores[$j + 1] = $scores[$j];
        $users[$j + 1] = $users[$j];
        $j--;
    }
    $scores[$j + 1] = $score_value;
    $users[$j + 1] = $user_value;
}

$scores_to_json = json_encode((array)$scores);
$users_to_json = json_encode((array)$users);

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
        <p> You have: <?php echo($gold) ?> gold. </p>
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
