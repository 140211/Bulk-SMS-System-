<?php
ob_start();
session_start();
include_once 'DBconnection.php';
$message = test_input($_POST["Cam_Name"]);

function test_input($data) {
   		$data = trim($data);
   		$data = stripslashes($data);
   		$data = htmlspecialchars($data);
   		return $data;
	}
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
	   bo  rder-bottom: 1px solid #ddd;
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
          <th><strong><font position="center" size = "5">Compaign name</font></strong></th>
          <th><strong><font align="center" size = "5">Details</font></strong></th>     
        </tr>

    <?php
   // $sql = "SELECT * FROM contacts, compaign where cntctID = cmpinID" ;
       
  //$sql = "SELECT * FROM contacts, compaign where contacts.userID = compaign.userID and compaign.Title LIKE *'".test."'*" ;
    $sql = "SELECT Title,txt FROM compaign WHERE Title = '" . $message. "' " ;
    

    


  // for message
    $result = mysqli_query($connection, $sql);
    while($row = mysqli_fetch_array($result))
    {
    ?>
        <tr> 
          <td><font color="#000000" size = "4.5"><?php echo ($row['Title']); ?></font></td>
          
           <td><form action='pretest2.php' method='POST'><input type='submit' name='insert' value='SHOW DETAILS'" . "></td>
        </tr>
  	<?php
    }
    ?>
  </div>
</div>

</body>
</html>