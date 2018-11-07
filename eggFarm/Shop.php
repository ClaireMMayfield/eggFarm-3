<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Shop</title>
    <style>
    .commonEgg{position:absolute; left:50px; top:450px;}
    .rareEgg{position:absolute;left:950px; top:500px;}
    .ultraRareEgg{position:absolute; left:500px; top:450px;}
    .uncommonEgg{position:absolute;left:1350px; top:450px}
    .button1{position:absolute; left: 70px; top:550px;}
    .button2{position:absolute; left:530px; top:550px}
    .button3{position:absolute; left:950px; top:550px;}
    .button4{position:absolute; left:1350px; top: 550px;}
    h1.commonEgg1{position:absolute; left:50px; top:650px}
    h1.rareEgg1{position:absolute; left:500px; top:650px}
    h1.ultraRareEgg1{position:absolute;left:950px; top:650px}
    h1.uncommonEgg1{position:absolute; left:1350px; top:650px}
    h1.goldM{position:absolute; left:0px;top:0px;}

        body{
        background-color:lightblue;
        font-family:Courier New;
        }
        .column{
        float:left;
        width:33.33%;
        padding:10px;

 }
 .row:after{
 content:"";
 display: table;
 clear:both;
 }
    </style>

</head>
<body>
<div class="buy" style"text-align:center; vertical-align:middle;">
<h1>Welcome to the Egg Shop!</h1>
</div>
<!--Egg Row Images-->
<!--Common White Egg-->
<img id="commonEgg" src = "common_whiteegg.png" alt="Common Egg" class="commonEgg" />
<!--Rare Dino Egg -->
<img id="ultraRareEgg" src = "rare_dinoegg.png" alt="Ultra Rare Egg" class="ultraRareEgg"/>
<!--Rare Lizard Egg-->
<img id="rareEgg" src="spr_rareegg_0.png" alt="Rare Egg" class="rareEgg"/>
<!-- Rare Blue Egg-->
<img id="uncommonEgg" src="ultrarare_blueegg.png" alt="Uncommon Egg" class = "uncommonEgg"/>


<h2 id = "goldM" class="goldM">Your Gold: 1500</h2>
<!--Div for button Row-->
<div align="center" style="position: absolute;">
<!-- Common Egg-->

<form action='GameScreen.php?image=egg' class="button1" method="get">
<button onclick="purchase(this)" value='common_whiteegg' name="egg" style="top:0px;left:180px;">500
            <img style="height: 35px;" src="eggPlant2_files/sprite_coin_0.png"/>
            </button>

</form>

<!-- Rare Dino Egg-->

<form action='GameScreen.php?image=egg' class= "button2" method="get">
            <button onclick="purchase(this)" value = "rare_dinoegg" name="egg"  style="top:0px;left:410px;">1000
            <img style="height: 35px;" src="eggPlant2_files/sprite_coin_0.png"/>
            </button>

</form>

<!-- Ultra Rare Lizard Egg -->

<form action='GameScreen.php?image=egg' class="button3" method="get">
<button onclick="purchase(this)" value = "superrare_lizardegg" name="egg" style="top:0px;left:630px;">1500
            <img style="height: 35px;" src="eggPlant2_files/sprite_coin_0.png"/>
            </button>

</form>

<!-- Uncommon Blue Egg-->
<form action='GameScreen.php?button=egg' class="button4" method="get">

<button onclick="purchase(this)" value = "ultrarare_blueegg" name="egg" style="top:0px;left:860px;">2000
            <img style="height: 35px;" src="eggPlant2_files/sprite_coin_0.png"/>
            </button>

</form>

    <input type="submit" value="Back to Home Screen">

<script type="text/javascript">
        var totalc= 1000;

    function purchase(x){
        var selected_egg = x.value;
        if (selected_egg=="common_whiteegg") {
            totalc= totalc-500;
            document.getElementById("total").textContent = "Gold coins:"+ " " + totalc;
        }
        else if (selected_egg=="rareEgg") {
            totalc= totalc-1000;
            document.getElementById("total").textContent = "Gold coins:"+ " " + totalc;

        }
        else if (selected_egg=="lizardegg") {
            totalc=totalc-1500;
            document.getElementById("total").textContent = "Gold coins:"+ " " + totalc;

        }
        else if (selected_egg=="blueegg") {
            totalc=totalc-2000;
            document.getElementById("total").textContent = "Gold coins:"+ " " + totalc;
        }
	}

    </script>





</body>
</html>
