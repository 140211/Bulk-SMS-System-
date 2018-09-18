<?php
session_start();
ob_start();

if(isset($_SESSION['usr_id']) == '') {
    header("Location: \Final\login and registration form\login.php");
}
?>

<!doctype html>

<head>
<title> This is a test copy!</title>
<link rel="stylesheet" href="bootstrap.min.css" type="text/css" />
</head>

	<style type="text/css">
	
        body{
			background-image: url("banner-bulksms.jpg");
			background-size: 100% 200%;;			
			background-repeat: no-repeat;
            background-color: white ;
			background-image: linear-gradient(to bottom, rgba(0,0,0,0.6) 0%,rgba(0,0,0,0.6) 100%), url("banner-bulksms.jpg");
            font-family: "Times New Roman";
        }		
        h1{
            color: white;			
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
<h1><center>Bulk SMS Service </center></h1>
<p id="subheader"><center style="color:white; font-weight:bold; font-family:Calibri, sans-serif; font-size:16px; "> Use Bulk...Save gelt.</center></p>
<br>

<p style="color:blue">Upload your excel:</p>


<form action="merge.php" method="post" enctype="multipart/form-data">

    <label for="fileSelect" style="color:white">Navigate and choose:</label>
    <input type="file" name="file" accept=".xls,.xlsx" /><br><br>
    <input type="submit" name="submit" value = "upload"/>

</form>
<br>

<FORM METHOD="LINK" ACTION="homepage.php">
    <INPUT TYPE="submit" VALUE="Menu">
</FORM>


</body>
</html>

