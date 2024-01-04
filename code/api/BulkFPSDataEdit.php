<?php
require('../util/Connection.php');
require('../structures/FPS.php');
require('../util/SessionFunction.php');


// Filter the excel data 
function filterData(&$str){ 
    $str = str_replace("\t", "", $str);
}


try{
	if (isset($_POST["submit"])){
		$fileName = $_FILES["file"]["tmp_name"];
		if ($_FILES["file"]["size"] > 0) {
			
			$file = fopen($fileName, "r");
			$i = 0;
			$district = 0;
			$name = 1;
			$id = 2;
			$type = 3;
			$demand = 4;
			$longitude = 5;
			$latitude = 6;
			while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
				if($i>0){
					$FPS = new FPS;
					filterData($column[$district]);
					filterData($column[$latitude]);
					filterData($column[$longitude]);
					filterData($column[$name]);
					filterData($column[$id]);
					filterData($column[$type]);
					filterData($column[$demand]);
					$uniqueid = uniqid("FPS_",);
					$FPS->setUniqueid(substr($uniqueid,0,15));
					$FPS->setDistrict($column[$district]);
					$FPS->setLatitude($column[$latitude]);
					$FPS->setLongitude($column[$longitude]);
					$FPS->setName($column[$name]);
					$FPS->setId($column[$id]);
					$FPS->setType($column[$type]);
					$FPS->setDemand($column[$demand]);
					$query_check = $FPS->checkEdit($FPS);
					$query_result = mysqli_query($con, $query_check);
					$numrows = mysqli_num_rows($query_result);
					if($numrows==0){
						echo "Error in loading data as FPS id doesn't exist : ".$column[$id];
						exit();
					}
					$query_update = $FPS->updateEdit($FPS);
					mysqli_query($con, $query_update);
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
	}
	else{
		echo "Error Please Select .csv file";
	}
}
catch(Exception $e){
	echo "Error Please check data in  .csv file";
}
?>