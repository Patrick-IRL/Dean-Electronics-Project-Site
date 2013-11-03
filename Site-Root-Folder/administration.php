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
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "users/login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dean Electronics - Administration</title>
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
<a href="<?php echo $logoutAction ?>">Logout</a> Level 2 User.
<?php
  }
elseif ($_SESSION['MM_UserGroup']==3) //user
  {
?>
<a href="<?php echo $logoutAction ?>">Logout</a> Level 3 user.
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
    	<h2>Administration</h2>
    	<p><a href="contact/contact-viewall.php">Contact</a></p>
    	<h2>Mods</h2>
    	<p>Products</p>
    	<p><a href="mods/mods-pedals-newproduct.php">Add a new Product (Effects Pedals)</a></p>
    	<p>To Edit or Delete a Product<br />
    	<a href="mods/mods.php">Browse Product List (Effects Pedals)</a></p>
    	<p>Orders</p>
    	<p><a href="mods/mods-amps-viewall.php">Amplifier Mod Requests</a><br />
        <a href="mods/mods-pedals-orderlist.php">Effects Pedal Orders</a></p>
    	<h2>Custom</h2>
    	<p>Products</p>
    	<p><a href="custom/custom-pedals-newproduct.php">Add a New Product (Effects Pedals)</a><br />
        <a href="custom/custom-amps-newproduct.php">Add a New Product (Amplifiers)</a></p>
    	<p>To Edit or Delete a Product<br />
        <a href="custom/custom-pedals.php">Browse Product List (Effects Pedals)</a><br />
        <a href="custom/custom-amps.php">Browse Product List (Amplifiers)</a></p>
    	<p>Orders</p>
    	<p><a href="custom/custom-amps-vieworders.php">Custom Build Amplifier Orders</a><br />
        <a href="custom/custom-pedals-vieworders.php">Custom Build Effects Pedal Orders</a></p>
    	<h2>Service and Repairs</h2>
    	<p><a href="repairsandservices/repairs-servicing-viewall.php">Service and Repair Requests</a></p>
    	<h2>Users</h2>
    	<p>To Edit/Delete Users<br />
    	<a href="users/users-viewall.php">View User List</a></p>
	</div>

   
   
<div id="footer">Site Design: Patrick Moorehouse - The company Dean Electronics is owned and run by Dean Moorehouse.</div></div>
</body>
</html>