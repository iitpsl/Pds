<?php
require('../util/Connection.php');
require('../util/SessionFunction.php');
require('../structures/Login.php');

if(!SessionCheck()){
	return;
}

$reviewed = "";
$approved = "";
$district = $_POST['district'];

if(isset($_POST['approved'])){
	$approved = $_POST['approved'];
}

if(isset($_POST['reviewed'])){
	$reviewed = $_POST['reviewed'];
}

$query = "SELECT * FROM optimiseddata WHERE from_district='$district'";
if($reviewed=="reviewed"){
	$query = "SELECT * FROM optimiseddata WHERE from_district='$district' AND reviewed='yes'";
}
else if($reviewed=="notreviewed"){
	$query = "SELECT * FROM optimiseddata WHERE from_district='$district' AND reviewed<>'yes'";
}

if($approved=="approved"){
	$query = "SELECT * FROM optimiseddata WHERE from_district='$district' AND approve='yes'";
}
else if($approved=="notapproved"){
	$query = "SELECT * FROM optimiseddata WHERE from_district='$district' AND approve<>'yes'";
}

$result = mysqli_query($con,$query);
while($row = mysqli_fetch_array($result))
{
	$data[] = $row;
}

$query_warehouse = "SELECT * from warehouse WHERE district='$district' ";
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