<?php
session_start();

if(isset($_SESSION['usr_id'])!="") {
	header("Location: homepage.php");
}

include_once 'dbconnect.php';


	$error = false;
//check if form is submitted
if (isset($_POST['login'])) {

	$phone = mysqli_real_escape_string($con, $_POST['phone']);
	$amount = mysqli_real_escape_string($con, $_POST['amount']);
	$result = mysqli_query($con, "SELECT * FROM bkash WHERE phone = '" . $phone. "' and amount = '" . $amount . "'");

	//name can contain only alpha characters and space
	if(!strlen($amount) >= 10) {
		$error = true;
		$amount_error = "Amount limit: Minimum 10 BDT & Maximum 100 BDT !";
	}

	if(strlen($mobile) != 11) {
		$error = true;
		$mobile_error = "Mobile number invalid ! ";
	}
	// if(!preg_match("/^[0-9]+$/",$mobile) && strlen($mobile) == 11) {
	// 	$error = true;
	// 	$mobile_error = "Mobile number invalid ! ";
	// }
	if (!$error) {
		if(mysqli_query($con, "INSERT INTO `bkash`(`id`, `phone`, `amount`, `package`) VALUES ('','" . $phone . "', '" . $amount . "', 'prepaid'))")) {
			$successmsg = "Successfully Registered! <a href='homepage.php'>Click here to enter...</a>";
		} else {
			$errormsg = "Error in registering...Please try again later!";
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>PHP Login Form</title>
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
				<li class="active"><a href="login.php">Login</a></li>
				<li><a href="register.php">Sign Up</a></li>
			</ul>
		</div>
	</div>
</nav>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
				<fieldset>
					<legend>Bkash payment</legend>
					
					<span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>

					<div class="form-group">
						<label for="name">Phone Number</label>
						<input type="text" name="phone" placeholder="Enter phone number..." required class="form-control" />
					</div>

					<div class="form-group">
						<label for="name">Amount</label>
						<input type="text" name="amount" placeholder="Enter amount..." required class="form-control" />
					</div>

					<div class="form-group">
						<input type="submit" name="Submit" value="Submit" class="btn btn-primary" />
						<input type="button" name="preview" value="Preview" class="btn btn-primary" />
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
