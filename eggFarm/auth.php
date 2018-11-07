<?php

if(isset($_POST['submit'])) {
	$firstName = $_POST['firstname'];
	$lastName = $_POST['lastname'];

	$myfile= fopen("user.txt", "a") or die("file not found");
	$data = array();

	$txt = $firstName.":".$lastName."\n";

	fwrite($myfile, $firstName.":".$lastName."\n");

	echo "<h2>Data written to user.txt!</h2>";

	// header("Location: index.html"); // redirects back to index.html

	fclose($myfile);
}

?>
