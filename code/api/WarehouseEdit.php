<?php

require('../util/Connection.php');
require('../structures/Warehouse.php');
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
$storage = $_POST["storage"];
$warehousetype = $_POST["warehousetype"];
$uniqueid = $_POST["uniqueid"];


$Warehouse = new Warehouse;
$Warehouse->setUniqueid($uniqueid);
$Warehouse->setDistrict($district);
$Warehouse->setLatitude($latitude);
$Warehouse->setLongitude($longitude);
$Warehouse->setName($name);
$Warehouse->setId($id);
$Warehouse->setType($type);
$Warehouse->setStorage($storage);
$Warehouse->setWarehousetype($warehousetype);

$query = $Warehouse->update($Warehouse);
echo $query;
mysqli_query($con, $query);

mysqli_close($con);
header("Location:../Warehouse.php");

?>
