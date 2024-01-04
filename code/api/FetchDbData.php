<?php
require('../util/Connection.php');
require('../structures/District.php');
require('../util/SessionFunction.php');
require('../structures/Login.php');

if(!SessionCheck()){
	return;
}

$reviewed = "";
$approved = "";

if(isset($_POST['approved'])){
	$approved = $_POST['approved'];
}

if(isset($_POST['reviewed'])){
	$reviewed = $_POST['reviewed'];
}

$query = "SELECT * FROM optimiseddata WHERE 1";
if($reviewed=="reviewed"){
	$query = "SELECT * FROM optimiseddata WHERE reviewed='yes'";
}
else if($reviewed=="notreviewed"){
	$query = "SELECT * FROM optimiseddata WHERE reviewed<>'yes'";
}

if($approved=="approved"){
	$query = "SELECT * FROM optimiseddata WHERE approve='yes'";
}
else if($approved=="notapproved"){
	$query = "SELECT * FROM optimiseddata WHERE approve='no'";
}

$result = mysqli_query($con,$query);
while($row = mysqli_fetch_array($result))
{
	$data[] = $row;
}

$query_warehouse = "SELECT * from warehouse WHERE 1";
$result_warehouse = mysqli_query($con,$query_warehouse);
while($row_warehouse = mysqli_fetch_array($result_warehouse)){
	$warehouse[] = $row_warehouse;
}
$resultarray = [];
if($data==null){
	$data = array();
}
$resultarray["data"] = $data;
$resultarray["warehouse"] = $warehouse;
echo json_encode($resultarray);
?>