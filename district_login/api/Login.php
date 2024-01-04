<?php


require('../util/Connection.php');
require('../structures/Login.php');

$person = new Login;
$person->setUsername($_POST["username"]);
$person->setPassword($_POST["password"]);

$query = "SELECT * FROM login WHERE username='".$person->getUsername()."' AND password='".$person->getPassword()."'";
$result = mysqli_query($con,$query);
$numrows = mysqli_num_rows($result);

if($numrows == 0){
	echo "Password is incorrect";
}
else if($numrows > 0){
	$row = mysqli_fetch_assoc($result);
	if($row["verified"]==0){
		echo "Your account needs to be verified please contact admin";
	}
	else{
		session_start();
		$_SESSION['district_user'] = $person->getUsername();
		$_SESSION['district_password'] = $person->getPassword();
		$_SESSION['district_district'] = $row["role"];
		mysqli_close($con);
		header("Location:../Home.php");
	}
}

?>
