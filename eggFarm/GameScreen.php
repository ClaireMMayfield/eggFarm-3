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

<?php
$egg_type = $_GET['egg'];
$configfile = fopen("config.txt", "r") or die("Unable to open file");
$data = array();
$temp = array();
while(!feof($configfile)) {
    $line = fgets($configfile);
    $temp = explode(":", $line);
    if(count($temp) == 1)
        continue;
    $data[$temp[0]] = $temp[1];
}
fclose($configfile);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game Screen</title>

    <style>
        body{
            background-color:lightblue;
            font-family:Courier New;
        }
        .nest{
            position:fixed;
            left:-65px;
            top:450px;
            z-index:-1;
        }
        .animalLocation{
            position:fixed;
            left:65px;
            top:325px;
            z-index:1;
        }
        .sell{
            position:absolute;
            left: 200px;
        }
        .keep{
            position:absolute;
        }
    </style>
</head>

<body>
<h1>Are you ready to play, <?php echo $username?>?</h1>
<h2>Press the start button when you are ready!</h2>
<a href="HomeScreen.php">
    <input type="submit" action="HomeScreen.php" value="Back to Home Screen">
</a>
<button id ="startButton">Start</button>
<h3 id="your_gold">Your Gold: <?php echo($_SESSION['gold'])?> </h3>

<span id="tapArea">
            <img src="eggPlant2_files/<?php echo $_GET['egg'];?>.png" id = "selected_egg" class = "nest1" style="height: 350px;"/>
            <img class= "nest" src = "nest1.png" alt="Common nest" style="width:500px; height:200px">
    </span>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<h3 id="statement">Hi Player 1!</h3>
<h3 id="result"> </h3>

<p id="tapCount">Taps: 0</p>
<p id="timer">Timer: </p>

<img id="sellAnimalButton" alt = "Sell" src = "sprite_sell_0.png" class="sell">
<img id ="keepAnimalButton" alt = "Keep" src = "sprite_keep_0.png" class="keep">

<?php
$myfile = fopen("config.txt","r") or die ("Unable to open file");
$data = array();
$temp = array();
while(!feof($myfile)){
    $line = fgets($myfile);
    $temp = explode(":",$line);
    if( !isset($temp[1])){
        $temp[1]= null;
    }
    $data[$temp[0]] = $temp[1];
}
fclose($myfile);
?>

<script type="text/javascript">
    var Done = false;
    var Game = {
        time:<?php echo $data['time']?>,
        gold:<?php echo $data['gold']?>,
        level1animal:<?php echo $data['level1animal']?>,
        level2animal: <?php echo $data['level2animal']?>,
        level3animal: <?php echo $data['level3animal']?>,
        level4animal: <?php echo $data['level4animal']?>,
        lessclick: <?php echo $data['lessclick']?>,
        minlevel1click: <?php echo $data['minlevel1click']?>,
        maxlevel1click: <?php echo $data['maxlevel1click']?>,
        minlevel2click: <?php echo $data['minlevel2click']?>,
        maxlevel2click: <?php echo $data['maxlevel2click']?>,
        minlevel3click: <?php echo $data['minlevel3click']?>,
        maxlevel3click: <?php echo $data['maxlevel3click']?>,
        minlevel4click: <?php echo $data['minlevel4click']?>,
        basePath: "../",
        animal: "rare_dino"
    };
    var Start;
    Start = false;
    var type_of_egg;
    var selected_egg;
    tapArea.addEventListener("click", addUp, false);
    startButton.addEventListener("click",start,false);


    /*
    * Loads the configuration file for the game
    */
    function loadFile(filePath) {
        var result = null;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", filePath, false);
        xmlhttp.send();
        if (xmlhttp.status==200) {
            result = xmlhttp.responseText;
        }
        return result;
    }

    /*
    * Starts the game, assigns type of egg for image lookups.
    * */
    function start(){
        Start = true;
        selected_egg = document.getElementById('selected_egg');
        type_of_egg = <?=json_encode($egg_type)?>;
    }
    var timer_done = setInterval(function() {
        if(Start == true) {
            document.getElementById("timer").innerHTML = "Timer: " + Game.time;
            Game.time -= 1;
            if (Game.time == 0) {
                document.getElementById("timer").innerHTML = "Timer: " + "OVER!!!";
                clearInterval(timer_done);
                Done = true;
                if(x >= 40) {
                    if(x < 50) {
                        selected_egg.src = "eggPlant2_files/" + type_of_egg + "_crack4.png";
                        document.getElementById("statement").innerHTML = "Yes... You got a chick!!!";
                        Game.animal = "sprite_chick";
                        Game.frameNum = 3;
                        createAnimal()
                    }
                    if(x >= 50 && x < 60){
                        selected_egg.src = "eggPlant2_files/" + type_of_egg + "_crack4.png";
                        document.getElementById("statement").innerHTML = "Yes... You got a lizard!!!";
                        Game.animal = "sprite_lizard";
                        Game.frameNum = 4;
                        createAnimal()
                    }
                    if(x>=60) {
                        selected_egg.src = "eggPlant2_files/" + type_of_egg + "_crack4.png";
                        document.getElementById("statement").innerHTML = "Yes... You got a dino!!!";
                        Game.animal = "sprite_dino";
                        Game.frameNum = 4;
                        createAnimal()
                    }
                }
                else{
                    selected_egg.src = "eggPlant2_files/" + type_of_egg + "_crack4.png";
                    document.getElementById("statement").innerHTML = "Oh no, you got nothing.";
                    Game.animal = "none";
                    Game.frameNum = 0;
                }
            }
        }
    },100);

    /*
    * Adding event listeners to the keep and sell buttons.
    * */
    keepAnimalButton.addEventListener("click", keepAnimal, false);
    sellAnimalButton.addEventListener("click", sellAnimal, false);
    document.getElementById('keepAnimalButton').style.display='none';
    document.getElementById('sellAnimalButton').style.display='none';

    /*
    * Function for handling keeping an animal. Removes the "Keep" and "Sell" buttons from the screen.
    * */
    function keepAnimal(){
        debugger
        var result = null;
        var animal = (Game.animal).replace("sprite_", "");

        var xmlhttp = new XMLHttpRequest();
        var variables_to_send = "animal_name='" + animal + "'";
        xmlhttp.open("GET", ("Update.php?" + variables_to_send), true);
        xmlhttp.onreadystatechange = complete;
        xmlhttp.send();
        console.log("Status is: " + xmlhttp.status);
        // Create end game elements after the ajax call to save the animal is made.
        document.getElementById("result").innerHTML = "Good decision! You will collect gold from your animals!";
        document.getElementById('keepAnimalButton').style.display = 'none';
        document.getElementById('sellAnimalButton').style.display = 'none';
        //document.getElementById('animal_type').value = Game.animal;
    }

    // Callback function.
    function complete() {
        console.log("Animal was successfully sent!")
    }

    /*
    * Function for selling an animal.
    * */
    function sellAnimal(){
        debugger
        // Update gold
        var new_gold = parseInt(<?php echo($_SESSION['gold'])?>) + 500;

        // Ajax call
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "Update.php?inquiry='gold'&gold='" + new_gold + "'", true);
        xmlhttp.send();

        //Update gold on screen if successful Ajax call
        /*
        if (xmlhttp.status == 200) {
            document.getElementById('your_gold').innerHTML = "Your new gold is: " + new_gold;
        }
        */

        // Create end game elements after the ajax call to save the new gold amount.
        document.getElementById("result").innerHTML = "Congrats! You'll earn gold for selling your animal!";
        document.getElementById('keepAnimalButton').style.display = 'none';
        document.getElementById('sellAnimalButton').style.display = 'none';
        document.getElementById('your_gold').innerHTML = "Your new gold is: " + new_gold;
    }

    /*
    * Function for creating animal html image element and getting number of frames for animating.
    * */
    var frameNum = 0;
    function createAnimal() {
        var x = document.createElement("IMG");
        var path_to_animal = Game.animal + "_1.png";
        x.setAttribute("src", path_to_animal);
        x.setAttribute("id", "animal");
        x.setAttribute("class", "animalLocation");
        document.body.appendChild(x);
        setInterval(frame, 500);
        document.getElementById('sellAnimalButton').style.display = 'block';
        document.getElementById('keepAnimalButton').style.display = 'block';
        if(Game.animal == "sprite_chick"){
            frameNum = 7;
        }
        else if(Game.animal == "sprite_lizard"){
            frameNum = 3;
        }
        else if(Game.animal == "sprite_dino"){
            frameNum = 3;
        }
    }

    /*
    * Function for animating animal when egg has been hatched.
    * */
    var curFrame = 0;
    function frame() {
        document.getElementById("animal").src = Game.animal + "_" + curFrame + ".png";
        curFrame += 1;
        if (curFrame > frameNum)
            curFrame = 0;
    }

    /*
    * Function for incrementing click counter while playing game.
    * */
    var x = 0;
    function addUp() {
        document.getElementById("tapCount").innerHTML = "Taps: " + x;
        if (!Done && Start) {
            x = x + 1;
            if (x > 10 && x < 20) {
                selected_egg.src = "eggPlant2_files/" + type_of_egg + "_crack1.png";
                document.getElementById("statement").innerHTML = "Yes... Got it";
            }
            if (x > 20 && x <30) {
                selected_egg.src = "eggPlant2_files/" + type_of_egg + "_crack2.png";
                document.getElementById("statement").innerHTML = "Yes... Keep tapping!!";
            }
            if (x > 30) {
                selected_egg.src = "eggPlant2_files/" + type_of_egg + "_crack3.png";
                document.getElementById("statement").innerHTML = "Yes... Getting Close!!";
            }
        }
    }
</script>
</body>
</html>
