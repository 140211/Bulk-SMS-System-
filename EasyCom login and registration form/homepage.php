
<?php
session_start();
include_once 'dbconnect.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<!-- add header -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">Bulk SMS System</a>
		</div>
		<!-- menu items -->
		<div class="collapse navbar-collapse" id="navbar1">
		<ul class="nav navbar-nav navbar-right">
			<?php if (isset($_SESSION['usr_id'])) { ?>
			<li>Signed in as <?php echo $_SESSION['usr_name']; ?></li>
			<li><a href="logout.php">Log Out</a></li>
			<?php } else { ?>
			<li><a href="login.php">Login</a></li>
			<li><a href="register.php">Sign Up</a></li>
			<?php } ?>
		</ul>
		</div>
	</div>
</nav>



<!-- <a href="Login_page.php" class="btn btn-default" style="float:right;">Logout</a> -->
<head>
<title> Design </title>
<link rel="stylesheet" href="font-awesome.css">
<link rel="stylesheet" type="text/css" href="style.css">

<style type="text/css">

body{
	padding: 0;
	margin: 0:
}

#nav {
	width: 100%;
	height: 200px;
	/*color :DarkSeaGreen  ;*/
	background-image: url(bulksms.jpg);	
	background-repeat: no-repeat;
	background-position: center top;
}

.menu ul{
	list-style:none;
	margin:0;
	padding: 0;
}
.menu ul li{
	padding: 15px;
	position: relative;
	width: 150px;
	vertical-align: middle;
	background-color: #34495E;
	cursor: pointer;
	border-right: 5px solid #F1C40F;
	border-top: 1px solid #BDC3C7;
}
.menu ul li:hover{
	background-color: #2ECC71;
}
.menu ul ul{
	transition: all 0.3s;
	opacity: 0;
	position: absolute;
	border-left: 5px solid #F1C40F;
	visibility: hidden;
	left: 100%;
	top: -2%;
	
}
.menu ul li:hover > ul {
	opacity: 1;
	visibility: visible;
}
.menu ul li a{
	color: #fff;
	text-decoration: none;
}
.menu > ul > li::after{
	
	position: absolute;
	
	color: #fff;
	font-size: 20px;
}

</style>

</head>
<body>
 
 <div id="nav" class="nav-bar"><br>
 <div id="nav_wrapper"><br>
 <ul>
	<li><a href="#">Home Menu</a></li>
	<li><a href="#">Blog Menu</a></li>
	<li><a href="#">Our Services</a></li>
	<li><a href="#">Portal</a></li>
	<li><a href="#">About</a></li>
 
 </ul>
 </div>
 
 </div>
   
   <div class="menu">
   <ul>
   <li><a href="http://localhost/Final/index.php">Sent_sms</a></li>
   <li><a href="http://localhost/Final/retrive.php">Retrive</a></li>
      </div>
   
   
</body>


<br>

</html>