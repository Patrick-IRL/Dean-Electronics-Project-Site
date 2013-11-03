<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dean Electronics - Home</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
</head>

<body id="homepage">
<div id="wrapper" class="clearfix">
  <div id="header">
  	<div id="logo"><a href="index.php"><img src="images/logo1.png" width="300" height="120" alt="Dean Electronics Logo" /></a></div>
    <div id="accesscontrol">
    
     <?php
if ($_SESSION['MM_UserGroup']==1) //admin
  {
?>
     <a href="<?php echo $logoutAction ?>">Logout</a> - <a href="administration.php">Administration</a>
<?php
  }
elseif ($_SESSION['MM_UserGroup']==2) //superuser
  {
?>
<a href="<?php echo $logoutAction ?>">Logout</a>
Level 2 User.
<?php
  }
elseif ($_SESSION['MM_UserGroup']==3) //user
  {
?>
<a href="<?php echo $logoutAction ?>"> Logout</a> Level 3 user.
<?php
  }
else
  {
?>
	<a href="users/login.php">Login</a> - <a href="users/register.php">Register</a>
<?php
  }
  ?>
    
    </div>
  </div>
  
  <div id="topnav">
    <ul>
      <li><a href="index.php" id="homelink">Home</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="contact/contact.php">Contact</a></li>
      <li><a href="mods/mods.php">Mods</a></li>
      <li><a href="custom/custom-builds.php">Custom</a></li>
      <li><a href="repairsandservices/repairs-servicing.php">Repairs And Services</a></li>
    </ul>
  </div>
  
  <div id="navbar">
    <h3>Mods</h3>
    <ul>
      <li><a href="mods/mods-pedals-list.php">Effects Pedals</a>
	<ul>
          <li><a href="mods/mods-pedals-make.php?brandid=1">Boss</a></li>
          <li><a href="mods/mods-pedals-make.php?brandid=2">Ibanez</a></li>
          <li><a href="mods/mods-pedals-make.php?brandid=3">Other</a></li>
	</ul>
    </li>
	<li><a href="mods/mods-amps.php">Amplifiers</a></li>
    </ul>
    <h3>Custom Builds</h3>
    <ul>
      <li><a href="custom/custom-pedals.php">Effects Pedals</a></li>
      <li><a href="custom/custom-amps.php">Amplifiers</a></li>
    </ul>
    <h3>Repairs and Servicing</h3>
    <ul>
      <li><a href="repairsandservices/repairs-servicing.php">Services and Repairs</a></li>
    </ul>
  </div>
  
  <div id="mainarea">
  <h2>Welcome To Dean Electronics!</h2>
  <p>Welcome to Dean electronics. This is a small company focusing on great products at great prices. Our pedals and amplifiers offer a wide range   of possibilities with many flavours and tones to help sculpt your own personal sound. We are passionate about this and are proud to offer unique products with characters of their own!</p>
  <p>Please feel free to browse our product listings.</p>
  
  <h4 style="color:#990000">DISCLAIMER: This is not a real site. This site was created as part of a college Web Design project.</h4>
  
  <div id="homepage1">
    <h3><a href="custom/custom-builds.php">Custom Build Effects Pedals and Amplifiers</a></h3>
    </div>
    
<div id="homepage2">
    <h3><a href="mods/mods.php">Effects Pedal and Amplifier Modifications</a></h3>
    </div>
    
    <div id="homepage3">
    <h3><a href="repairsandservices/repairs-servicing.php">Servicing and Repairs</a></h3>
    </div>
  
  </div>
   
<div id="footer">Site Design: Patrick Moorehouse - The company Dean Electronics is owned and run by Dean Moorehouse.</div>
</div>
</body>
</html>