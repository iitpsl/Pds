<?php
require('../util/Connection.php');
require('../structures/District.php');
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

$uid = $_POST["uid"];

if($uid!="all"){
	$subject = "Test email";
	$message = "This is a test email sent using the mail function in PHP.";
	$headers = "From: ".$_SESSION['user'];
	/*$mailSent = mail($to, $subject, $message, $headers);

	if ($mailSent) {
		echo "Email sent successfully!";
	} else {
		echo "Error: Unable to send email.";
	}*/
}
else{
	$query = "SELECT username FROM login WHERE 1";
	$result = mysqli_query($con,$query);
	while($rows = mysqli_fetch_array($result))
	{
		$to = $rows['username'];
		$subject = "Test email";
		$message = "This is a test email sent using the mail function in PHP.";
		$headers = "From: ".$_SESSION['user'];
		
		/*$mailSent = mail($to, $subject, $message, $headers);

		if ($mailSent) {
			echo "Email sent successfully!";
		} else {
			echo "Error: Unable to send email.";
		}*/
	}
}
header("Location:../SendEmail.php");

?>
