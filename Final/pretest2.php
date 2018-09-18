<!DOCTYPE HTML> 
<html>
<head>
<style>

body{
    background-color: #C5D0D1;
    font-family: "Times New Roman";
}

.error {color: #FF0000;}

table {
    width:50%;
}
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
    text-align: left;
}
tr:nth-child(even) {
    background-color: #eee;
}
tr:nth-child(odd) {
   background-color:#fff;
}
th	{
    background-color: black;
    color: white;
}

</style>
</head>
<body> 

<?php

	include 'excel_reader.php';
	include_once 'DBconnection.php';
	$excel = new PhpExcelReader;

	ob_start();
	session_start();

	// define variables and set to values
	$message = test_input($_POST["message"]);
	$compaignName = test_input($_POST["cmpinName"]);
	$name_file = test_input($_POST["fileName"]);
	$selectsheet = test_input($_POST["selectSheet"]);
	$mobile = test_input($_POST["mobil"]);
	$message = " ".$message ;	
		

	$excel->read("uploaded\\" . $name_file);

	$nr_sheets = count($excel->sheets);       // gets the number of sheet_tabs

	function test_input($data) {
   		$data = trim($data);
   		$data = stripslashes($data);
   		$data = htmlspecialchars($data);
   		return $data;
	}
	
	// for mobile number

	$pos   = '(';	
	$pos1 = strpos($mobile, $pos);	
	$pos   = ')';
	$pos2 = strpos($mobile, $pos);	
	$pos2 = $pos2 - $pos1 ;
	$mob_shet = substr($mobile,$pos1+1,$pos2-1);

	$pos   = '{';	
	$pos1 = strpos($mobile, $pos);	
	$pos   = '}';
	$pos2 = strpos($mobile, $pos);	
	$pos2 = $pos2 - $pos1 ;
	$mob_col = substr($mobile,$pos1+1,$pos2-1);

	// for message

	$temp = $message;
	$find = array();   
	$replace = "";

	$shet_colm = array();
	$i = 0;
	for($i=0; ; $i=$i+1) 
	{
		$pos   = '[[';	
		$pos1 = strpos($temp, $pos);	
		if($pos1=='')
			break;
		$pos   = ']]';
		$pos2 = strpos($temp, $pos);	
		$pos2 = $pos2 - $pos1 ;
		$cellarray = substr($temp,$pos1+2,$pos2-2);


		// for column and sheet number

		$shet_colm[$i] = array();

		$pos   = '(';	
		$pos1 = strpos($cellarray, $pos);	
		$pos   = ')';
		$pos2 = strpos($cellarray, $pos);	
		$pos2 = $pos2 - $pos1 ;
		$shet_colm[$i][0] = substr($cellarray,$pos1+1,$pos2-1);
		
		$pos   = '{';	
		$pos1 = strpos($cellarray, $pos);	
		$pos   = '}';
		$pos2 = strpos($cellarray, $pos);	
		$pos2 = $pos2 - $pos1 ;
		$shet_colm[$i][1] = substr($cellarray,$pos1+1,$pos2-1);

		$find[$i] = '[['.$cellarray.']]';
		$replace = "";

		echo ''.$replace;

		$temp = str_replace($find[$i], $replace, $temp);

	}

	// table message generate

	$messageShow = "<table><tr><th>Mobile Number</th><th>Message</th></tr>";
	$smsStatus = array();

	$con=11;
	for($j = 2; $j <= $excel->sheets[0]['numRows']; $j++)
	{
		$temp = $message;
		
		for($k = 0; $k < $i; $k++)
		{
			$replace = " ".$excel->sheets[$shet_colm[$k][0]]['cells'][$j][$shet_colm[$k][1]] ." ";				

			$temp = str_replace($find[$k],$replace, $temp);
			$s=$k+1;
			         
		mysqli_query($connection,"INSERT INTO sms_info(ID, indx, vlue, smsID) VALUES ('','".$s."','".$replace."','".$con."')");
		
          }
		$con++;

		// for mobile

		$p = test_input($excel->sheets[$mob_shet]['cells'][$j][$mob_col]);

		mysqli_query($connection,"INSERT INTO contacts(cntctID, grpID, userID, name , numbers) VALUES ('','1','".$_SESSION['usr_id']."','nadia','" . $p . "')");

		$m = urlencode($temp);
		$m1 = (string)$m;

		$sendsms = 'https://bmpws.robi.com.bd/ApacheGearWS/SendTextMessage?Username=Sumit_M&Password=Sumit@123&From=8801841155900&To=' . $p . '&Message=' . $m ;
		
		$report = file_get_contents($sendsms);

		$smsStatus[$j] = substr($report, -32, 1);

		echo $report . "<br>";

		$messageShow = $messageShow ."<tr><td>".$excel->sheets[$mob_shet]['cells'][$j][$mob_col]."</td><td>". $temp . "</td></tr>";
	}

	$messageShow = $messageShow . "</table>";

	echo $messageShow;


	// message status
	$smsCount = 0;
	for($j = 2; $j < $excel->sheets[0]['numRows']; $j++)
	{
		if($smsStatus[$j] != $smsStatus[$j+1])
			$smsCount++;
	}

	$smsCount++;
	$inc=10;

	echo "<br><br>    Total Send Sms : " .($excel->sheets[0]['numRows'] - 1). "<br>    Successfully Submitted : " . $smsCount . "<br>    Sms Send Failed : " . ($excel->sheets[0]['numRows'] - 1 - $smsCount) ;

	 //mysqli_query($connection,"INSERT INTO `compaign`(`cmpinID`, `dates`, `userID`, `name`, `successful`, `txt`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6])");

	//mysqli_query($connection,"INSERT INTO compaign(cmpinID, dates, userID, Title, successful, txt) VALUES ('',now(),'2','" . $compaignName . "','" . $smsCount . "','" . $message . "')");
	//mysqli_query($connection,"INSERT INTO contacts(cntctID, grpID, userID, name , numbers) VALUES ('','1','2','nadia','" . $mobile . "'')");
	mysqli_query($connection,"INSERT INTO `compaign`(`cmpinID`, `dates`, `userID`, `Title`, `successful`, `txt`) VALUES ('',now(),'".$_SESSION['usr_id']."','" . $compaignName . "','" . $smsCount . "','" . $message . "')");
	// mysqli_query(INSERT INTO `contacts`(`cntctID`, `grpID`, `userID`, `name`, `numbers`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5])
       $a=77;
       $ck_qry="SELECT count(cmpinID)FROM compaign";
      $compaign_id=mysqli_query($connection,$ck_qry); 
      
      $compaign_id=$compaign_id+$a;
     // echo "$compaign_id";
      $contact_id="SELECT count(*) FROM 'contacts' ";
      
      mysqli_query($connection,"INSERT INTO `sent_sms`(`smsID`, `cmpinID`, `cntctID`) VALUES ('','" . $compaign_id . "','" . $contact_id . "'");
   
	



?>

</body>
</html>