<?php
require('Connection.php');

$ip_address = "";

if (!empty($_SERVER['HTTP_CLIENT_IP']))   
  {
	$ip_address = $_SERVER['HTTP_CLIENT_IP'];
  }
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
  {
	$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
else
  {
	$ip_address = $_SERVER['REMOTE_ADDR'];
  }

session_start();
if(isset($_SESSION['user'])){
	$user = $_SESSION['user'];
	$source = "";
	$query = "SELECT * FROM login WHERE username='$user'";
	$result = mysqli_query($con,$query);
	$numrows = mysqli_num_rows($result);
	
	
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   
    
    // Append the requested resource location to the URL   
    $url.= $_SERVER['REQUEST_URI'];
	
	//error_log($user."    ".$url."    ".$ip_address);
	
	if($numrows==0){
		header("Location:Login.html");
	}
}
else{
	header("Location:Login.html");
}

?>
