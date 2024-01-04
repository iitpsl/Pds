<?php
require('../util/Connection.php');
require('../structures/Warehouse.php');
require('../util/SessionFunction.php');


try{
	//if (isset($_POST["submit"])){
		$fileName = $_FILES["file"]["tmp_name"];
		if ($_FILES["file"]["size"] > 0) {
			
			$file = fopen($fileName, "r");
			$i = 0;
			$district = 0;
			$name = 1;
			$id = 2;
			$warehousetype = 3;
			$type = 4;
			$latitude = 5;
			$longitude = 6;
			$storage = 7;
			while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
				if($i>0){
					$Warehouse = new Warehouse;
					$uniqueid = uniqid("WH_",);
					$Warehouse->setUniqueid(substr($uniqueid,0,15));
					$Warehouse->setDistrict($column[$district]);
					$Warehouse->setLatitude($column[$latitude]);
					$Warehouse->setLongitude($column[$longitude]);
					$Warehouse->setName($column[$name]);
					$Warehouse->setId($column[$id]);
					$Warehouse->setType($column[$type]);
					$Warehouse->setStorage($column[$storage]);
					$Warehouse->setWarehousetype($column[$warehousetype]);
					while(true){
						$query_check = $Warehouse->check($Warehouse);
						$query_result = mysqli_query($con, $query_check);
						$numrows = mysqli_num_rows($query_result);
						if($numrows==0){
							break;
						}
						else{
							$uniqueid = uniqid("WH_",);
							$Warehouse->setUniqueid(substr($uniqueid,0,15));
						}
					}
					$query_add = $Warehouse->insert($Warehouse);
					mysqli_query($con, $query_add);
				}
				else{
					for($j=0;$j<count($column);$j++){
						switch($column[$j]){
							case "state":
								$state = $j;
								break;
							case "district":
								$district = $j;
								break;
							case "latitude":
								$latitude = $j;
								break;
							case "longitude":
								$longitude = $j;
								break;
							case "name":
								$name = $j;
								break;
							case "id":
								$id = $j;
								break;
							case "type":
								$type = $j;
								break;
							case "storage":
								$storage = $j;
								break;
							case "warehousetype":
								$warehousetype = $j;
								break;
						}
					}
				}
				$i = $i+1;
			}
			header("Location:../Warehouse.php");
		}
	//}
	//else{
		//echo "Error Please Select .csv file";
	//}
}
catch(Exception $e){
	echo "Error Please check data in  .csv file";
}
?>