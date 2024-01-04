<?php

require('../util/Connection.php');
require('../structures/FPS.php');
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

$district = $_POST["district"];
$latitude = $_POST["latitude"];
$longitude = $_POST["longitude"];
$name = $_POST["name"];
$id = $_POST["id"];
$type = $_POST["type"];
$demand = $_POST["demand"];
$uniqueid = $_POST["uniqueid"];


$FPS = new FPS;
$FPS->setUniqueid($uniqueid);
$FPS->setDistrict($district);
$FPS->setLatitude($latitude);
$FPS->setLongitude($longitude);
$FPS->setName($name);
$FPS->setId($id);
$FPS->setType($type);
$FPS->setDemand($demand);

$query = $FPS->update($FPS);
echo $query;
mysqli_query($con, $query);

mysqli_close($con);
header("Location:../FPS.php");

?>
