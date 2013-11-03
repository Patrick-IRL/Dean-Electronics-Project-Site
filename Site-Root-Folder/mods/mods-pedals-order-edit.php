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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tblpedalmodorders SET datesubmitted=%s, pedalorderstatus_id=%s, fname=%s, lname=%s, email=%s, phone=%s, brand_id=%s, pedalmodelname=%s, priceordered=%s WHERE id=%s",
                       GetSQLValueString($_POST['datesubmitted'], "date"),
                       GetSQLValueString($_POST['pedalorderstatus_id'], "int"),
                       GetSQLValueString($_POST['fname'], "text"),
                       GetSQLValueString($_POST['lname'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['brand_id'], "int"),
                       GetSQLValueString($_POST['pedalmodelname'], "text"),
                       GetSQLValueString($_POST['priceordered'], "double"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_deanelectro, $deanelectro);
  $Result1 = mysql_query($updateSQL, $deanelectro) or die(mysql_error());

  $updateGoTo = "mods-pedals-orderlist.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_deanelectro, $deanelectro);
$query_rstbrand = "SELECT * FROM otblbrand";
$rstbrand = mysql_query($query_rstbrand, $deanelectro) or die(mysql_error());
$row_rstbrand = mysql_fetch_assoc($rstbrand);
$totalRows_rstbrand = mysql_num_rows($rstbrand);

mysql_select_db($database_deanelectro, $deanelectro);
$query_rststatus = "SELECT * FROM otblservstatus";
$rststatus = mysql_query($query_rststatus, $deanelectro) or die(mysql_error());
$row_rststatus = mysql_fetch_assoc($rststatus);
$totalRows_rststatus = mysql_num_rows($rststatus);

$colname_rstpedalmodorder = "-1";
if (isset($_GET['id'])) {
  $colname_rstpedalmodorder = $_GET['id'];
}
mysql_select_db($database_deanelectro, $deanelectro);
$query_rstpedalmodorder = sprintf("SELECT * FROM tblpedalmodorders WHERE id = %s", GetSQLValueString($colname_rstpedalmodorder, "int"));
$rstpedalmodorder = mysql_query($query_rstpedalmodorder, $deanelectro) or die(mysql_error());
$row_rstpedalmodorder = mysql_fetch_assoc($rstpedalmodorder);
$totalRows_rstpedalmodorder = mysql_num_rows($rstpedalmodorder);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dean Electronics - Pedal Mods - Update Orders</title>
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
      <li><a href="mods.php" id="modlink">Mods</a></li>
      <li><a href="../custom/custom-builds.php">Custom</a></li>
      <li><a href="../repairsandservices/repairs-servicing.php">Repairs And Services</a></li>
    </ul>
  </div>
  
  <div id="navbar">
    <h3>Mods</h3>
    <ul>
      <li><a href="mods-pedals-list.php">Effects Pedals</a>
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
    <h2>Pedal Mod Order List</h2>
    <p>&nbsp;</p>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Status:</td>
          <td><select name="pedalorderstatus_id">
            <?php 
do {  
?>
            <option value="<?php echo $row_rststatus['status_id']?>" <?php if (!(strcmp($row_rststatus['status_id'], htmlentities($row_rstpedalmodorder['pedalorderstatus_id'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_rststatus['status']?></option>
            <?php
} while ($row_rststatus = mysql_fetch_assoc($rststatus));
?>
          </select></td>
        </tr>
        <tr> </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">First Name:</td>
          <td><input type="text" name="fname" value="<?php echo htmlentities($row_rstpedalmodorder['fname'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Last Name:</td>
          <td><input type="text" name="lname" value="<?php echo htmlentities($row_rstpedalmodorder['lname'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Email:</td>
          <td><input type="text" name="email" value="<?php echo htmlentities($row_rstpedalmodorder['email'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Phone:</td>
          <td><input type="text" name="phone" value="<?php echo htmlentities($row_rstpedalmodorder['phone'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Brand:</td>
          <td><select name="brand_id">
            <?php 
do {  
?>
            <option value="<?php echo $row_rstbrand['brandid']?>" <?php if (!(strcmp($row_rstbrand['brandid'], htmlentities($row_rstpedalmodorder['brand_id'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_rstbrand['brandname']?></option>
            <?php
} while ($row_rstbrand = mysql_fetch_assoc($rstbrand));
?>
          </select></td>
        </tr>
        <tr> </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Pedal Model Name:</td>
          <td><input type="text" name="pedalmodelname" value="<?php echo htmlentities($row_rstpedalmodorder['pedalmodelname'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Price:</td>
          <td><input type="text" name="priceordered" value="<?php echo htmlentities($row_rstpedalmodorder['priceordered'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Update record" /></td>
        </tr>
      </table>
      <input type="hidden" name="id" value="<?php echo $row_rstpedalmodorder['id']; ?>" />
      <input type="hidden" name="datesubmitted" value="<?php echo htmlentities($row_rstpedalmodorder['datesubmitted'], ENT_COMPAT, 'utf-8'); ?>" />
      <input type="hidden" name="MM_update" value="form1" />
      <input type="hidden" name="id" value="<?php echo $row_rstpedalmodorder['id']; ?>" />
    </form>
    <p>&nbsp;</p>
  </div>
<div id="footer">Site Design: Patrick Moorehouse - The company Dean Electronics is owned and run by Dean Moorehouse.</div></div>

</body>
</html>
<?php
mysql_free_result($rstbrand);

mysql_free_result($rststatus);

mysql_free_result($rstpedalmodorder);
?>
