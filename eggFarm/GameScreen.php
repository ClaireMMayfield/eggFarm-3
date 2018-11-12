<?php
session_start();
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
    //echo $tmp_arry[0] ."..".$tmp_arry[1];
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
            top:550px;
            z-index:-1;
        }
        .animalLocation{
            position:fixed;
            left:-36px;
            top:170px;
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
    <h1 id="eggPath"> Egg Path echoed from php is: <?php echo $egg_type; ?> </h1>
    <h1>Are you ready to play?</h1>
    <h2>Press the start button when you are ready!</h2>
    <button id ="startButton">Start</button>
    <h3>Your Gold: 150</h3>

    <!-- Here I kept your naming scheme with "selected_egg", except now it refers to only the HTML document element. -->
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
    <h3 id="statement">Hi Player 1!</h3>

    <p id="tapCount">Taps: 0</p>
    <p id="timer">Timer: </p>

    <img id="sellA" alt = "Sell" src = "sprite_sell_0.png" class="sell"> </image>
    <img id = "keepA" alt = "Keep" src = "sprite_keep_0.png" class="keep">  </image>

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
            frameNum: 4,
            animal: "rare_dino"
        };

        var Start;
        Start = false;

        /* Here, you had selected_egg defined within the start function which meant that you could only
        * access it through the local scope of the that function. Outside of it, Php_Get would return
        * the document element of the html image which is why we were getting the weird path.
        */
        var type_of_egg;
        var selected_egg;
        tapArea.addEventListener("click", addUp, false);
        startButton.addEventListener("click",start,false);

        /*
        * I redefined your selected_egg to be "type_of_egg" (i.e. common, rare, etc...)
        * and declared it outside the start function so that it would be within scope of updating the animation.
        * In addition, I kept the HTML element as "selected_egg" where we would be updating the src to change the image.
        * */
        function start(){
            Start = true;
            selected_egg = document.getElementById('selected_egg');
            type_of_egg = <?=json_encode($egg_type)?>;
        }

        /*
        * Here, I noticed that if your score was 50, it wouldn't be registered through your if statement and go directly
        * towards the bracket meant to catch scores over 60.
        * */
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
                        else {
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




        keepA.addEventListener("click", keepB, false);
        sellA.addEventListener("click", sellB, false);
        document.getElementById('sellA').style.display='none';
        document.getElementById('keepA').style.display='none';

        function keepB(){
            test.innerHTML = "Good decision! You will collect gold from your animals!";
            document.getElementById('keepA').style.display = 'none';
            document.getElementById('sellA').style.display = 'none';
        }

        function sellB(){
            test.innerHTML = "Congrats! You'll earn gold for selling your animal!";
            document.getElementById('keepA').style.display = 'none';
            document.getElementById('sellA').style.display = 'none';
        }

        /*
        * This I'll work on with you tomorrow. Currently it'll append the animal to the body
        * of the html. However, we need to layer them on top of each other by changing
        * the z index of the animal over the egg using CSS. Also, your game path was wrong.
        * We can fix that as well depending on how you want to organize your images.
        *
        * In addition, the indexing was starting from 0 while the files names were starting from 1.
        * This led to a few 404's.
        * */
        function createAnimal() {
            var x = document.createElement("IMG");
            //var str = Game.basePath + Game.animal + "_1.png";
            var path_to_animal = Game.animal + "_1.png";
            // Added this line for debugging.
            // Relative path: sprite_dino_1.png
            document.getElementById("eggPath").innerHTML = "Animal's path is: " + path_to_animal;
            x.setAttribute("src", path_to_animal);
            x.setAttribute("id", "animal");
            x.setAttribute("class", "animalLocation");
            document.body.appendChild(x);
            setInterval(frame, 500);
            document.getElementById('sellA').style.display = 'block';
            document.getElementById('keepA').style.display = 'block';
        }

        var curFrame = 1;
        function frame() {
            document.getElementById("animal").src = Game.animal + "_" + curFrame + ".png";
            document.getElementById("statement").innerHTML = "Yes... You got it!! ";
            curFrame += 1;
            if (curFrame > Game.frameNum)
                curFrame = 1;
        }

        var x = 0;

        /*
        * I left the comments where I was printing the path in case it helps.
        * I also added && Start to your increment condition. Previously you could click on the egg before starting the game and increment x.
        * */
        function addUp() {
            document.getElementById("tapCount").innerHTML = "Taps: " + x;
            // document.getElementById("eggPath").innerHTML = "Egg path from javascript is: " + type_of_egg;
            if (!Done && Start) {
                x = x + 1;
                if (x > 10 && x < 20) {
                    selected_egg.src = "eggPlant2_files/" + type_of_egg + "_crack1.png";
                    //document.getElementById("eggPath").innerHTML = "Egg path from javascript is: eggPlant2_files/" + type_of_egg + "_crack1.png";
                    document.getElementById("statement").innerHTML = "Yes... Got it";
                }
                if (x > 20 && x <30) {
                    selected_egg.src = "eggPlant2_files/" + type_of_egg + "_crack2.png";
                    //document.getElementById("eggPath").innerHTML = "Egg path from javascript is: eggPlant2_files/" + type_of_egg + "_crack2.png";
                    document.getElementById("statement").innerHTML = "Yes... Keep tapping!!";
                }
                if (x > 30) {
                    selected_egg.src = "eggPlant2_files/" + type_of_egg + "_crack3.png";
                    //document.getElementById("eggPath").innerHTML = "Egg path from javascript is: eggPlant2_files/" + type_of_egg + "_crack3.png";
                    document.getElementById("statement").innerHTML = "Yes... Getting Close!!";
                }
            }
        }
    </script>
</body>
</html>
