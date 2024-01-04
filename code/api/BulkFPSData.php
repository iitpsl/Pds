<?php
require('../util/Connection.php');
require('../structures/FPS.php');
require('../util/SessionFunction.php');

try{
	//if (isset($_POST["submit"])){
		$fileName = $_FILES["file"]["tmp_name"];
		if ($_FILES["file"]["size"] > 0) {
			
			$file = fopen($fileName, "r");
			$i = 0;
			$state = 0;
			$district = 1;
			$name = 2;
			$id = 3;
			$type = 4;
			$demand = 5;
			$longitude = 6;
			$latitude = 7;
			while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
				if($i>0){
					$FPS = new FPS;
					$uniqueid = uniqid("FPS_",);
					$FPS->setUniqueid(substr($uniqueid,0,15));
					//$FPS->setState($column[$state]);
					$FPS->setDistrict($column[$district]);
					$FPS->setLatitude($column[$latitude]);
					$FPS->setLongitude($column[$longitude]);
					$FPS->setName($column[$name]);
					$FPS->setId($column[$id]);
					$FPS->setType($column[$type]);
					$FPS->setDemand($column[$demand]);
					while(true){
						$query_check = $FPS->check($FPS);
						$query_result = mysqli_query($con, $query_check);
						$numrows = mysqli_num_rows($query_result);
						if($numrows==0){
							break;
						}
						else{
							$uniqueid = uniqid("FPS_",);
							$FPS->setUniqueid(substr($uniqueid,0,15));
						}
					}
					$query_add = $FPS->insert($FPS);
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
							case "demand":
								$demand = $j;
								break;
						}
					}
				}
				$i = $i+1;
			}
			header("Location:../FPS.php");
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