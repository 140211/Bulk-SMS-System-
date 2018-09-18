<?php
	$servername="localhost";
	$username="root";
	$password="";
	//$dbname="bulk_sms_system";
	$dbname="bulk_sms_system";
	//$dbname="bulk_sms system";

	//create connection
	$connection = mysqli_connect($servername,$username,$password,$dbname);

	//check connection
	if(!$connection){

		die("connection failed!".mysqli_connect_error());
	}
?>

