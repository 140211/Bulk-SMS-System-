
<?php
ob_start();
session_start();

include_once 'DBconnection.php';

if(isset($_SESSION['usr_id']) == '') {
    //header("Location: \Final\login and registration form\login.php");
    header("Location: http://localhost/final/re.php");

}
?>

<!doctype html>

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

<h1><center> Search compaign name into database and Retrive data from database.</center></h1>
<br>

<form method="post" action="retrieve.php"> 
   
       <label for="name">Compaign name :</label>
            <textarea name="Cam_Name" rows="2" cols="20" placeholder="Enter compaign name:" ></textarea>
            <br><br>

            
       
            <input type="submit" name="submit" value="Search"> 

</form>

<FORM METHOD="LINK" ACTION="http://localhost/EasyCom%20login%20and%20registration%20form/homepage.php">
    <br>
    <INPUT TYPE="submit" VALUE="Back to Main Page">
</FORM>

</body>
</html>

