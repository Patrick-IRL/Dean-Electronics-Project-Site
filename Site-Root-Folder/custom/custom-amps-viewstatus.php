<?php require_once('../Connections/deanelectro.php'); ?>
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

$MM_restrictGoTo = "../users/login.php";
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
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_rstcampviewstatus = "-1";
if (isset($_GET['status_id'])) {
  $colname_rstcampviewstatus = $_GET['status_id'];
}
mysql_select_db($database_deanelectro, $deanelectro);
$query_rstcampviewstatus = sprintf("SELECT p.*, b.`status`, c.* FROM `tblcustomamporders` AS p JOIN `otblservstatus` AS b     ON p.`caorderstatus_id` = b.`status_id` JOIN `otblwattage` AS c     ON p.`watt_id` = c.`wattid` WHERE status_id = %s", GetSQLValueString($colname_rstcampviewstatus, "int"));
$rstcampviewstatus = mysql_query($query_rstcampviewstatus, $deanelectro) or die(mysql_error());
$row_rstcampviewstatus = mysql_fetch_assoc($rstcampviewstatus);
$totalRows_rstcampviewstatus = mysql_num_rows($rstcampviewstatus);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dean Electronics - Custom Amplifiers - View Orders</title>
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
</head>

<body id="modpage">

<div id="wrapper" class="clearfix">

<div id="header"> <a href="../index.php"><img src="../images/logo1.png" width="300" height="120" alt="Dean Electronics Logo" /></a>
  </div>
  
   <div id="topnav">
    <ul>
      <li><a href="../index.php">Home</a></li>
      <li><a href="../about.php">About</a></li>
      <li><a href="../contact/contact.php">Contact</a></li>
      <li><a href="mods-pedals-list.php" id="modlink">Mods</a></li>
      <li><a href="../custom/custom-builds.php">Custom</a></li>
      <li><a href="../repairsandservices/repairs-servicing.php">Repairs And Services</a></li>
    </ul>
  </div>
  
  <div id="navbar">
    <h3>Mods</h3>
    <ul>
      <li><a href="../mods/mods-pedals-list.php">Effects Pedals</a>
	<ul>
          <li><a href="mods-pedals-make.php?brandid=1">Boss</a></li>
          <li><a href="mods-pedals-make.php?brandid=2">Ibanez</a></li>
          <li><a href="mods-pedals-make.php?brandid=3">Other</a></li>
        </ul>
      </li>
      <li><a href="mods-amps.php">Amplifiers</a></li>
    </ul>
    <h3>Custom Builds</h3>
    <ul>
      <li><a href="../custom/custom-pedals.php">Effects Pedals</a></li>
      <li><a href="../custom/custom-amps.php">Amplifiers</a></li>
    </ul>
    <h3>Repairs and Servicing</h3>
    <ul>
      <li><a href="../repairsandservices/repairs-servicing.php">Services and Repairs</a></li>
    </ul>
  </div>
  
  
  <div id="mainarea">
    <h2>Custom Amp Order List</h2>

  <p>Sort by Status: </p>
  <ul>
    <li><a href="custom-amps-viewstatus.php?status_id=1">Submitted</a></li>
    <li><a href="custom-amps-viewstatus.php?status_id=2">Pending</a></li>
    <li><a href="custom-amps-viewstatus.php?status_id=3">Accepted</a></li>
    <li><a href="custom-amps-viewstatus.php?status_id=4">InProgress</a></li>
    <li><a href="custom-amps-viewstatus.php?status_id=5">Completed</a></li>
  </ul>


          <?php do { ?>
            <div id="adminlistview">
              <table width="748" border="1" cellspacing="3" cellpadding="3">
                <tr>
                  <th scope="row">Request ID</th>
                  <td><?php echo $row_rstcampviewstatus['id']; ?></td>
                </tr>
                <tr>
                  <th scope="row">Date Submitted</th>
                  <td><?php echo $row_rstcampviewstatus['datesubmitted']; ?></td>
                </tr>
                <tr>
                  <th scope="row">Status</th>
                  <td><?php echo $row_rstcampviewstatus['status']; ?></td>
                </tr>
                <tr>
                  <th scope="row">First Name</th>
                  <td><?php echo $row_rstcampviewstatus['fname']; ?></td>
                </tr>
                <tr>
                  <th scope="row">Last Name</th>
                  <td><?php echo $row_rstcampviewstatus['lname']; ?></td>
                </tr>
                <tr>
                  <th scope="row">Email</th>
                  <td><?php echo $row_rstcampviewstatus['email']; ?></td>
                </tr>
                <tr>
                  <th scope="row">Phone</th>
                  <td><?php echo $row_rstcampviewstatus['phone']; ?></td>
                </tr>
                <tr>
                  <th scope="row">Wattage Band</th>
                  <td><?php echo $row_rstcampviewstatus['wattageband']; ?></td>
                </tr>
                <tr>
                  <th scope="row">Custom Amp  Model</th>
                  <td><?php echo $row_rstcampviewstatus['campname']; ?></td>
                </tr>
                <tr>
                  <th scope="row">Price</th>
                  <td><?php echo $row_rstcampviewstatus['camppriceordered']; ?></td>
                </tr>
                <tr>
                  <th scope="row">Moderation</th>
                  <td><a href="custom-amps-order-edit.php?id=<?php echo $row_rstcampviewstatus['id']; ?>">Edit</a> - <a href="custom-amps-order-delete.php?id=<?php echo $row_rstcampviewstatus['id']; ?>">Delete</a></td>
                </tr>
              </table>
          </div>
            <?php } while ($row_rstcampviewstatus = mysql_fetch_assoc($rstcampviewstatus)); ?>
  </div>
<div id="footer">Site Design: Patrick Moorehouse - The company Dean Electronics is owned and run by Dean Moorehouse.</div></div>

</body>
</html>
<?php
mysql_free_result($rstcampviewstatus);
?>
