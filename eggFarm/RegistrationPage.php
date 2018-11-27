<?php
session_start();
$_SESSION['name_check'] = false;

$file_name = "user.txt";
$users_file = fopen($file_name, "r") or die("Unable to open file");
$users = [];
$tmp_arry = [];
$size = 0;
while(!feof($users_file)){
    $line = trim(fgets($users_file));
    $tmp_arry = explode(":", $line);
    if(!count($tmp_arry)==2){
        continue;
    }
    array_push($users, $tmp_arry[0]);
    $size = count($users) - 1;
}
$users_to_json = json_encode((array)$users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Page</title>
    <style>
     body{
        background-color:lightblue;
        font-family:Courier New;
        }
    </style>
</head>
    <body>
    <div id = "main">
        <div class = "h-tag">
        <h1>Welcome! Let's make an account!</h1>
        <form name="myForm" onsubmit="return validateForm()" name="create" method="POST" action="authorization.php">
        Enter Username:
        <input type="text" name="username" id = "username" required>
            <h3 id="warning"></h3>
            <br>
            <div id="message">
          <h3>Password must contain the following:</h3>
          <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
          <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
          <p id="number" class="invalid">A <b>number</b></p>
          <p id="length" class="invalid">Minimum <b>8 characters</b></p>
             </div>

        Enter Password:
        <input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required><br>


        <button type ="submit" name="login" class ="btn">Login</button>

    </form>


        <script>
         var x= document.getElementById("password").value;
         let existing_users = <?php echo($users_to_json)?>;

         function checkUserName() {
             let name_check = false;
             let username_to_test = document.getElementById("username");
             if(existing_users.includes(username_to_test)) {
                name_check = false;
             }
             else {
                 name_check = true;
             }
             return name_check;
         }

        function validateForm()
        {
            var letter = document.getElementById("letter");
            var capital = document.getElementById("capital");
            var number = document.getElementById("number");
            var length = document.getElementById("length");
            let username_html_element = document.getElementById("username");

            x.onfocus = function(){
            document.getElementById("message").style.display = "block";
            }
            x.onblur = function() {
            document.getElementById("message").style.display = "none";
            }
            x.onkeyup = function() {
            var lowerCaseLetters = /[a-z]/g;
            if (x.value.match(lowerCaseLetters)){
            letter.classList.remove("invalid");
            letter.classList.add("valid");
            }
            else{
            letter.classList.remove("valid");
            letter.classlist.add("invalid");
            }

            var upperCaseLetters = /[A-Z]/g;
            if(x.value.match(upperCaseLetters)){
            capital.classList.remove("invalid");
            capital.classList.add("valid");
            }
            else{
            capital.classList.remove("valid");
            capital.classList.add("invalid");
            }
            var numbers = /[0-9]/g;
            if (x.value.match(numbers)){
            number.classList.remove("invalid");
            number.classList.add("valid");
            }
            else{
            number.classList.remove("valid");
            number.classList.add("invalid");
            }
            if(x.value.length >=8){
            length.classList.remove("invalid");
            length.classList.remove("valid");
            }
            else{
            length.classList.remove("valid");
            length.classList.add("invalid");
            }
            }

            if(checkUserName()) {
                username.classList.remove("invalid");
                username.classList.add("valid");
                document.getElementById("warning").innerText = "Username has not been taken!";
            }
            else{
                username.classList.remove("valid");
                username.classList.add("invalid");
                document.getElementById("warning").innerText = "Username already taken! Try another!";
            }
            var message = document.getElementById('confirmMessage')
    }
        </script>
    </body>
</html>
