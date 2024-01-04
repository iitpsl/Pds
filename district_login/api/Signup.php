<?php


require('../util/Connection.php');
require('../structures/Login.php');

$password = $_POST['password'];
$confirmpassword = $_POST['confirmpassword'];

if($password=="" || $confirmpassword==""){
	echo "Password is Empty";
	return;
}
if($password!=$confirmpassword){
	echo "Both Password doesn't match";
	return;
}

$person = new Login;
$person->setUsername($_POST["username"]);
$person->setPassword($_POST["password"]);
$person->setRole($_POST["district"]);
$uid = uniqid();

$query = "SELECT * FROM login WHERE username='".$person->getUsername()."'";
$result = mysqli_query($con,$query);
$numrows = mysqli_num_rows($result);

if($numrows == 1){
	echo "Username already exist";
}
else if($numrows == 0){
	$query1 = "INSERT INTO login (username,password,uid,role,verified) VALUES ('".$person->getUsername()."','".$person->getPassword()."','$uid','".$person->getRole()."','0')";
	mysqli_query($con,$query1);

	mysqli_close($con);
	header("Location:../Login.html");
}
?>
