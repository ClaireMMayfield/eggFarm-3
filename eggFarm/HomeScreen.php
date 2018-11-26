<?php
session_start();
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
    <p>1. Steff Score:800 coins</p>
    <p>2. Brody Score:758 coins</p>
    <p>3. Jason Score:750 coins</p>
    <p>4. Allison Score:630 coins</p>
    <p>5. Nelly Score:625 coins</p>
    <p>6. Robbi Score:540coins</p>
    <p>7. Julie Score:430 coins</p>
    <p>8. Max Score:350 coins</p>
    <p>9. Nelly Score:340 coins</p>
    <p>10. Harriett Score:300 coins</p>
    </body>
</html>
