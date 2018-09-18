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
    <table align="center" width="60%" border="1">
        <tr> 
          <th><strong><font position="center" size = "5">Mobile</font></strong></th>
          <th><strong><font align="center" size = "5">Message</font></strong></th>     
        </tr>

    <?php
   // $sql = "SELECT * FROM contacts, compaign where cntctID = cmpinID" ;
     $sql = "SELECT * FROM contacts, compaign where contacts.userID = compaign.userID and compaign.Title LIKE *'".test."'*" ;
    

    $result = mysqli_query($connection,"SELECT * from sms_info INNER JOIN (SELECT sent_sms.smsID,sent_sms.cmpinID,compaign.txt from sent_sms INNER JOIN compaign WHERE sent_sms.cmpinID = compaign.cmpinID) new WHERE sms_info.smsID = new.smsID");

   //$sql = mysqli_query($connection,"SELECT * from sms_info INNER JOIN (SELECT sent_sms.smsID,sent_sms.cmpinID,compaign.txt from sent_sms INNER JOIN compaign WHERE sent_sms.cmpinID = compaign.cmpinID) new WHERE sms_info.smsID = new.smsID");

    $row = mysqli_fetch_array($result);
  // $row = mysqli_fetch_array($sql);



    $txt = $row['txt'];
    $value = $row['vlue'];
    $index = $row['indx'];
    echo "compaign.txt";



  // for message

 // $temp = $message;//$txt = $row['txt'];
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

 

    $temp = str_replace($find[$i], $replace, $temp);

  }

   /*for($j = 2; $j <= $excel->sheets[0]['numRows']; $j++)
  {
    $temp = $message;
    
    for($k = 0; $k < $i; $k++)
    {
      $replace = " ".$excel->sheets[$shet_colm[$k][0]]['cells'][$j][$shet_colm[$k][1]] ." ";        

      $temp = str_replace($find[$k],$replace, $temp);
      $s=$k+1;
               
      mysqli_query($connection,"INSERT INTO sms_info(ID, indx, vlue, smsID) VALUES ('','".$s."','".$replace."','".$con."')");
    
          }*/
         //$r= "REPLACE INTO compaign VALUES SELECT *, REPLACE(Region_name, ‘ast’, ‘astern’) FROM company_network;"
    
    $result = mysqli_query($connection, $sql);
    while($row=mysqli_fetch_array($result))
    {
    ?>
        <tr> 
          <td><font color="#000000" size = "4.5"><?php echo ($row['numbers']); ?></font></td>
          <td><font color="#000000" size = "4.5"><?php echo $row['txt']; ?></font></td>
        
        </tr>
  	<?php
    }
    ?>
  </div>
</div>

</body>
</html>