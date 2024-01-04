<?php
require('../util/Connection.php');
require('../util/SessionCheck.php');


foreach ($_POST as $key => $value) {
	$parts = explode("_", $key,2);
	$fromid = $parts[0];
	$toid = $parts[1];
	$toid = str_replace('_', '.', $toid);
	if($value=="yes"){
		$query = "UPDATE optimiseddata SET reviewed='yes' WHERE from_id='$fromid' AND to_id='$toid'";
	}
	else if($value=="no"){
		$query = "UPDATE optimiseddata SET reviewed='', new_id='', approve='' WHERE from_id='$fromid' AND to_id='$toid'";
	}
	else{
		$query = "UPDATE optimiseddata SET new_id='$value', reviewed='yes' WHERE from_id='$fromid' AND to_id='$toid'";
	}
	
	
	mysqli_query($con,$query);
}
mysqli_close($con);
header("Location:../Home.php");
?>