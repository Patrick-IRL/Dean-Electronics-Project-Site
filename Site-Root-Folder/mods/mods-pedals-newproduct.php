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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tblpedals (pedalid, pedalname, brand_id, cat_id, prodpic, `description`, price, picsmall, longdescription, pmpicalt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['pedalid'], "int"),
                       GetSQLValueString($_POST['pedalname'], "text"),
                       GetSQLValueString($_POST['brand_id'], "int"),
                       GetSQLValueString($_POST['cat_id'], "int"),
                       GetSQLValueString($_POST['prodpic'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['price'], "double"),
                       GetSQLValueString($_POST['picsmall'], "text"),
                       GetSQLValueString($_POST['longdescription'], "text"),
                       GetSQLValueString($_POST['pmpicalt'], "text"));

  mysql_select_db($database_deanelectro, $deanelectro);
  $Result1 = mysql_query($insertSQL, $deanelectro) or die(mysql_error());

  $insertGoTo = "mods.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_deanelectro, $deanelectro);
$query_rstnewpmod = "SELECT * FROM tblpedals";
$rstnewpmod = mysql_query($query_rstnewpmod, $deanelectro) or die(mysql_error());
$row_rstnewpmod = mysql_fetch_assoc($rstnewpmod);
$totalRows_rstnewpmod = mysql_num_rows($rstnewpmod);

mysql_select_db($database_deanelectro, $deanelectro);
$query_rstnewpmodbrand = "SELECT * FROM otblbrand";
$rstnewpmodbrand = mysql_query($query_rstnewpmodbrand, $deanelectro) or die(mysql_error());
$row_rstnewpmodbrand = mysql_fetch_assoc($rstnewpmodbrand);
$totalRows_rstnewpmodbrand = mysql_num_rows($rstnewpmodbrand);

mysql_select_db($database_deanelectro, $deanelectro);
$query_rstnewpmodcat = "SELECT * FROM otblcats";
$rstnewpmodcat = mysql_query($query_rstnewpmodcat, $deanelectro) or die(mysql_error());
$row_rstnewpmodcat = mysql_fetch_assoc($rstnewpmodcat);
$totalRows_rstnewpmodcat = mysql_num_rows($rstnewpmodcat);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dean Electronics - Pedal Mods - New Product</title>
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
    
    <h3>New Product Information</h3>
    <p>&nbsp;</p>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Pedal Model:</td>
          <td><input type="text" name="pedalname" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Brand:</td>
          <td><select name="brand_id">
            <?php 
do {  
?>
            <option value="<?php echo $row_rstnewpmodbrand['brandid']?>" ><?php echo $row_rstnewpmodbrand['brandname']?></option>
            <?php
} while ($row_rstnewpmodbrand = mysql_fetch_assoc($rstnewpmodbrand));
?>
          </select></td>
        </tr>
        <tr> </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Category:</td>
          <td><select name="cat_id">
            <?php 
do {  
?>
            <option value="<?php echo $row_rstnewpmodcat['catid']?>" ><?php echo $row_rstnewpmodcat['catname']?></option>
            <?php
} while ($row_rstnewpmodcat = mysql_fetch_assoc($rstnewpmodcat));
?>
          </select></td>
        </tr>
        <tr> </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Main Image URL:</td>
          <td><input type="text" name="prodpic" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Description:</td>
          <td><input type="text" name="description" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Price:</td>
          <td><input type="text" name="price" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Small Image URL</td>
          <td><input type="text" name="picsmall" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Long Description:</td>
          <td><input type="text" name="longdescription" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Description for Images</td>
          <td><input type="text" name="pmpicalt" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Insert record" /></td>
        </tr>
      </table>
      <input type="hidden" name="pedalid" value="" />
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
    <p>&nbsp;</p>
  </div>
<div id="footer">Site Design: Patrick Moorehouse - The company Dean Electronics is owned and run by Dean Moorehouse.</div></div>
</body>
</html>
<?php
mysql_free_result($rstnewpmod);

mysql_free_result($rstnewpmodbrand);

mysql_free_result($rstnewpmodcat);
?>
