<?php

function SessionCheck(){
	require('Connection.php');
	session_start();

	if(isset($_SESSION['user'])){
		$user = $_SESSION['user'];
		$query = "SELECT * FROM login WHERE username='$user'";
		$result = mysqli_query($con,$query);
		$numrows = mysqli_num_rows($result);
		if($numrows==0){
			return false;
		}
		else{
			return true;
		}
	}
	else{
		return false;
	}
}

?>
