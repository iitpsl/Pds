<?php
require('../util/Connection.php');
require('../util/SessionCheck.php');
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$district = $_SESSION['district_district'];

// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 
 
// Excel file name for download 
$fileName = "PDS_Optimised_Data" . date('d-m-Y') . ".csv"; 

$columns = ["from_district","from_id","from_name","to_district","to_id","to_name"];
$columnheading = ["From_District","From_Id","From_Name","To_District","To_Id","To_Name"];

$query = "SELECT * FROM optimiseddata WHERE from_district='$district'";
$result = mysqli_query($con,$query);
$numrows = mysqli_num_rows($result);
$rows = array();

if($numrows>0){
	while($row = mysqli_fetch_array($result)){
		$temp = array();
		for($i=0;$i<count($columns);$i++){
			if($columns[$i]=="from_id"){
				if(strlen($row["new_id"])>0 and $row["approve"]=="yes"){
					array_push($temp,$row["new_id"]);
				}
				else{
					array_push($temp,$row[$columns[$i]]);
				}
			}
			else{			
				array_push($temp,$row[$columns[$i]]);
			}
		}
		array_push($rows,$temp);
	}
}


// Create a new PhpSpreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set column names as the first row
$columnIndex = 1;
foreach ($columnheading as $columnName) {
    $sheet->setCellValueByColumnAndRow($columnIndex, 1, $columnName);
    $columnIndex++;
}

// Insert data rows
$rowIndex = 2;
foreach ($rows as $rowData) {
    $columnIndex = 1;
    foreach ($rowData as $value) {
        $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
        $columnIndex++;
    }
    $rowIndex++;
}


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$fileName.'');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

exit();

?>