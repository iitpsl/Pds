<?php
require('../util/Connection.php');
require('../util/SessionCheck.php');

foreach ($_POST as $key => $value) {
	$parts = explode("_", $key,2);
	$fromid = $parts[0];
	$toid = $parts[1];
	$toid = str_replace('_', '.', $toid);
	$query = "UPDATE optimiseddata SET approve='yes' WHERE from_id='$fromid' AND to_id='$toid'";
	if($value=="yes"){
		$query = "UPDATE optimiseddata SET approve='yes' WHERE from_id='$fromid' AND to_id='$toid'";
	}
	else if($value=="no"){
		$query = "UPDATE optimiseddata SET approve='no' WHERE from_id='$fromid' AND to_id='$toid'";
	}
	mysqli_query($con,$query);
	
	
}
mysqli_close($con);
header("Location:../OptimisedData.php");
?>