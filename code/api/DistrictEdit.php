<?php

require('../util/Connection.php');
require('../structures/District.php');
require('../util/SessionFunction.php');
require('../structures/Login.php');

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

$District = new District;

$District->setName(str_replace("'","",$_POST['name']));
$District->setId(str_replace("'","",$_POST['uid']));

$query = $District->update($District);
$result = mysqli_query($con,$query);

mysqli_close($con);

if($result){
	header("Location:../District.php");
}
else{
   echo "error";
}

?>
