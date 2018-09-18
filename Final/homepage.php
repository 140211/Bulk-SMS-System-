
<?php
session_start();
ob_start();

if(isset($_SESSION['usr_id']) == '') {
    header("Location: \Final\login and registration form\login.php");
}
?>

<!doctype html>

<?php

include_once 'DBconnection.php';

    $number = mysqli_real_escape_string($connection, $_POST['Number']);

mysqli_query($connection, "INSERT INTO contacts(cntctID, grpID, userID, name, numbers) VALUES ('','1','1','nadira','".$number."')");
?>

<head>
<title> This is a test copy!</title>
<link rel="stylesheet" href="bootstrap.min.css" type="text/css" />
</head>

	<style type="text/css">

        body{
            background-color: #C5D0D1;
            font-family: "Times New Roman";
        }

        h1{
            color: #ff0033;
            text-align: center;
        }

    </style>


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
        <a class="navbar-brand" >Bulk SMS Login Form</a>
    </div>
    <!-- menu items -->
    <div class="collapse navbar-collapse" id="navbar1">
        <ul class="nav navbar-nav navbar-right">
            <?php if (isset($_SESSION['usr_id'])) { ?>              
                <li>Logged in as <?php echo $_SESSION['usr_name']; ?></li>
                <li><a href="\Final\login and registration form\logout.php">Log Out</a></li>     
            <?php } else { ?>                
                <li class="menu-item"><a href="\Final\login and registration form\login.php">Login</a></li>
                <li class="menu-item"><a href="\Final\login and registration form\register.php">Sign Up</a></li>
            <?php } ?>
        </ul>
    </div>
</div>
</nav>

<body>
<h1><center> Excel to database conversion </center></h1>
<h1><center> You can convert your excel file info into database.</center></h1>
<br>

<form method="post" action="homepage.php"> 
   
       <label for="name">Contact Number :</label>
            <input type="text" name="Number" placeholder="Enter your number" />   <br><br>
       
            <input type="submit" name="submit" value="Submit"> 

</form>

<FORM METHOD="LINK" ACTION="index.php">
    <br>
    <INPUT TYPE="submit" VALUE="Back to Main Page">
</FORM>

</body>
</html>

