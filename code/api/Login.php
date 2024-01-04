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
	//if($row['district']!="admin"){
	//	echo "You don't have permission to access this";
	//}
	// else{
		session_start();
		$_SESSION['user'] = $person->getUsername();
		$_SESSION['password'] = $person->getPassword();
		mysqli_close($con);
		header("Location:../Home.php");
	// }
}

?>
