<?php

session_start();
error_reporting(0);

if(isset($_POST["username"]) && isset($_POST["password"]))
{
    //user.txt file
    $file=fopen("user.txt","r") or die("Unable to open file:".$filename);
    $finduser = false;
    while(!feof($file))
    {
        $line = fgets($file);
        $array = explode(":",$line);
        if(trim($array[0]) == $_POST['username'])
        {
            $finduser=true;
            break;
        }
    }
    fclose($file);

    if($finduser)
    {

        echo $_POST["username"]."\r\n";
        echo "is already registered!";
        include 'LoginScreen.html';
        header("Location: LoginScreen.php");
    }
    else
    {
        $file = fopen("user.txt", "a+") or die("Unable to open file:".$filename);
        fputs($file,$_POST["username"].":".$_POST["password"]."\r\n");
        fclose($file);
        echo "registered successfully!";
        include 'LoginScreen.html';
		header("Location: LoginScreen.php");
    //new user data file
    //all new users get 1000 gold pieces
	$data = 1000;
    //new users get a new user_data.txt file
    $dfile = $_POST["username"]."_data.txt";
    //adds data to file on new lines or dies
    $datafile = fopen($dfile, "w") or die("Can not open");
    $userinfo = "username".":".$_POST["username"]."\r\n"."gold".":".$data."\r\n";
    //adds username and gold amount to files
    fputs($datafile, $userinfo);
    //closes file after writing
    fclose($datafile);
		//immediately takes users back to the Login page
    }
}
?>
