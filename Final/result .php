<?php
ob_start();
session_start();
include_once 'DBconnection.php';
?>

<!DOCTYPE html>
<html>
<head>
  <head>
  <title>Result</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="login_files/bootstrap.min.css">
  <script src="login_files\jquery.min.js"></script>
  <script src="login_files\bootstrap.min.js"></script>
</head>

<style>
    body {
        background-color = #93B874;
        background-image: url("image/34.jpg");
    }    

    td {
	   border: 1px solid black;
	   border-bottom: 1px solid #ddd;
	   height: 30px;
	}
	
	tr:nth-child(even) {background-color: #f2f2f2}
	
	th {
	    background-color: #4CAF50;
	    color: white;
	}
        
  </style> 
<body>




</body>
</head>
<body>

<div class="container">
  <div class="info">
    <h1><center>BULK SMS System</center></h1>
    <h3><center>CSE Discipline, Khulna University</center></h3>
  </div>
</div>

<div class="container">
  <div class="info">

    <?php
  
    $result = mysqli_query($connection,"SELECT * from sms_info INNER JOIN (SELECT sent_sms.smsID,sent_sms.cmpinID,compaign.txt from sent_sms INNER JOIN compaign WHERE sent_sms.cmpinID = compaign.cmpinID) new WHERE sms_info.smsID = new.smsID"); 

    $last_id = mysqli_query($connection,"SELECT max(sms_info.smsID) as id from sms_info INNER JOIN (SELECT sent_sms.smsID,sent_sms.cmpinID,compaign.txt from sent_sms INNER JOIN compaign WHERE sent_sms.cmpinID = compaign.cmpinID) new WHERE sms_info.smsID = new.smsID"); 

	$row = mysqli_fetch_array($result);
  $last_id = mysqli_fetch_assoc($last_id);

	//while ($echo = mysqli_fetch_array($last_id)) {
		//echo $echo['id'] ;
	//}
    $last_id = $last_id['id'];

    $txt = $row['txt'];
    $value = $row['vlue'];
    $index = $row['indx'];

    //echo $txt.'<br>';
     //echo $value.'<br>';
      //echo $index.'<br>';

  // for message

  $temp = $txt;		
  $find = array();   
  $replace = "";

  $i = 0;
  for($i=0; ; $i=$i+1)
  {
    $pos  = '[[';  
    $pos1 = strpos($temp, $pos);  
    if($pos1=='')
      break;
    $pos   = ']]';
    $pos2 = strpos($temp, $pos);
    $pos2 = $pos2 - $pos1 ;
    $cellarray = substr($temp,$pos1+2,$pos2-2);

    $find[$i] = '[['.$cellarray.']]';
    $replace = $index;

    $temp = str_replace($find[$i], $replace, $temp);
  	}

    // table message generate
   //echo $temp;
   //echo $text;
	$messageShow = "<table><tr><th>Mobile Number</th><th>Message</th></tr>";

	for($j = 0; $j <= ($last_id-1); $j++)
	{
		$temp = $txt;
		
		for($k = 0; $k < $i; $k++)
		{
      $txt = $row['txt'];
      $value = $row['vlue'];
      $index = $row['indx'];
      $row = mysqli_fetch_array($result);
			
      if($i == 0)
				$replace = $value;

			else if($i=1){
				$replace = $value;
			}

      //echo $find[k].'??<br>';
      //echo $replace.'??<br>';
      //echo $temp.'??<br>';
			$temp = str_replace($find[$k],$replace, $temp);
     // echo $temp.'??<br>';

      $txt = $row['txt'];
      $value = $row['vlue'];
      $index = $row['indx'];
      $row = mysqli_fetch_array($result);
      $replace = $value;
      $temp = substr_replace($temp, $replace, 33, 14);
      
      $result5 = mysqli_query($connection,"SELECT distinct mobile from sms_info where vlue = '$value'");
        $mobile = mysqli_fetch_assoc($result5);
        $mobile = $mobile['mobile'];
		}

		//echo $report . "<br>";

		$messageShow = $messageShow ."<tr><td>" .$mobile ."</td><td>". $temp . "</td></tr>";
    //echo $messageShow.'--<br>';
	}

	$messageShow = $messageShow . "</table>";

	echo "<center>".$messageShow."</center>";
	?>
 
  </div>
</div>

</body>
</html>