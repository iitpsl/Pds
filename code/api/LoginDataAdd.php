<?php
require('../util/Connection.php');
require('../structures/Login.php');
require('../util/SessionFunction.php');

if(!SessionCheck()){
	return;
}

$person = new Login;
$person->setUsername($_POST["username"]);
$person->setPassword($_POST["password"]);

$query = "SELECT * FROM login WHERE username='".$person->getUsername()."' AND password='".$person->getPassword()."'";
$result = mysqli_query($con,$query);
$numrows = mysqli_num_rows($result);

if($numrows == 0){
	echo "Password or Username is incorrect";
	return;
}


$person = new Login;
$person->setUsername($_POST["newusername"]);
$person->setPassword($_POST["newpassword"]);
$person->setRole($_POST["district"]);
$uid = uniqid();

$query = "SELECT * FROM login WHERE username='".$person->getUsername()."'";
$result = mysqli_query($con,$query);
$numrows = mysqli_num_rows($result);

if($numrows == 1){
	echo "Username already exist";
}
else if($numrows == 0){
	$query1 = "INSERT INTO login (username,password,uid,role,verified) VALUES ('".$person->getUsername()."','".$person->getPassword()."','$uid','".$person->getRole()."','1')";
	mysqli_query($con,$query1);

	mysqli_close($con);
	header("Location:../Userdata.php");
}
?>
