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
  $updateSQL = sprintf("UPDATE tblcustompedals SET cpname=%s, cppic=%s, cppicsmall=%s, cpprice=%s, cpdesc=%s, cp_cat_id=%s, cplongdesc=%s, picalttag=%s WHERE id=%s",
                       GetSQLValueString($_POST['cpname'], "text"),
                       GetSQLValueString($_POST['cppic'], "text"),
                       GetSQLValueString($_POST['cppicsmall'], "text"),
                       GetSQLValueString($_POST['cpprice'], "double"),
                       GetSQLValueString($_POST['cpdesc'], "text"),
                       GetSQLValueString($_POST['cp_cat_id'], "int"),
                       GetSQLValueString($_POST['cplongdesc'], "text"),
                       GetSQLValueString($_POST['picalttag'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_deanelectro, $deanelectro);
  $Result1 = mysql_query($updateSQL, $deanelectro) or die(mysql_error());

  $updateGoTo = "custom-pedals.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsteditcp = "-1";
if (isset($_GET['id'])) {
  $colname_rsteditcp = $_GET['id'];
}
mysql_select_db($database_deanelectro, $deanelectro);
$query_rsteditcp = sprintf("SELECT * FROM tblcustompedals WHERE id = %s", GetSQLValueString($colname_rsteditcp, "int"));
$rsteditcp = mysql_query($query_rsteditcp, $deanelectro) or die(mysql_error());
$row_rsteditcp = mysql_fetch_assoc($rsteditcp);
$totalRows_rsteditcp = mysql_num_rows($rsteditcp);

mysql_select_db($database_deanelectro, $deanelectro);
$query_rsteditcpcats = "SELECT * FROM otblcats";
$rsteditcpcats = mysql_query($query_rsteditcpcats, $deanelectro) or die(mysql_error());
$row_rsteditcpcats = mysql_fetch_assoc($rsteditcpcats);
$totalRows_rsteditcpcats = mysql_num_rows($rsteditcpcats);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dean Electronics - Custom Pedals - Update Product Information</title>
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
</head>

<body id="custompage">
<div id="wrapper" class="clearfix">
  <div id="header"> <a href="../index.php"><img src="../images/logo1.png" width="300" height="120" alt="Dean Electronics Logo" /></a>
  </div>
  
   <div id="topnav">
    <ul>
      <li><a href="../index.php">Home</a></li>
      <li><a href="../about.php">About</a></li>
      <li><a href="../contact/contact.php">Contact</a></li>
      <li><a href="../mods/mods.php">Mods</a></li>
      <li><a href="custom-builds.php" id="customlink">Custom</a></li>
      <li><a href="../repairsandservices/repairs-servicing.php">Repairs And Services</a></li>
    </ul>
  </div>
  
  <div id="navbar">
     <h3>Mods</h3>
    <ul>
      <li><a href="../mods/mods-pedals-list.php">Effects Pedals</a>
	<ul>
          <li><a href="../mods/mods-pedals-make.php?brandid=1">Boss</a></li>
          <li><a href="../mods/mods-pedals-make.php?brandid=2">Ibanez</a></li>
          <li><a href="../mods/mods-pedals-make.php?brandid=3">Other</a></li>
        </ul>
      </li>
      <li><a href="../mods/mods-amps.php">Amplifiers</a></li>
    </ul>
    <h3>Custom Builds</h3>
    <ul>
      <li><a href="../custom/custom-pedals.php">Effects Pedals</a></li>
          <ul>
        	  <li><a href="cutsom-pedals-category.php?catid=5">Overdrive</a></li>
        	  <li><a href="cutsom-pedals-category.php?catid=2">Compression</a></li>
        	  <li><a href="cutsom-pedals-category.php?catid=7">Modulation</a></li>
    	      <li><a href="cutsom-pedals-category.php?catid=6">Wah/filter</a></li>
	      </ul>

      <li><a href="../custom/custom-amps.php">Amplifiers</a></li>
    </ul>
    <h3>Repairs and Servicing</h3>
    <ul>
      <li><a href="../repairsandservices/repairs-servicing.php">Services and Repairs</a></li>
    </ul>
  </div>
  
  <div id="mainarea">
   	<h3>Edit Product Information</h3>
   	<p>&nbsp;</p>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Pedal Model:</td>
          <td><input type="text" name="cpname" value="<?php echo htmlentities($row_rsteditcp['cpname'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Main Image URL:</td>
          <td><input type="text" name="cppic" value="<?php echo htmlentities($row_rsteditcp['cppic'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Small Image URL:</td>
          <td><input type="text" name="cppicsmall" value="<?php echo htmlentities($row_rsteditcp['cppicsmall'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Price:</td>
          <td><input type="text" name="cpprice" value="<?php echo htmlentities($row_rsteditcp['cpprice'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Short Description:</td>
          <td><input type="text" name="cpdesc" value="<?php echo htmlentities($row_rsteditcp['cpdesc'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Category:</td>
          <td><select name="cp_cat_id">
            <?php 
do {  
?>
            <option value="<?php echo $row_rsteditcpcats['catid']?>" <?php if (!(strcmp($row_rsteditcpcats['catid'], htmlentities($row_rsteditcp['cp_cat_id'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_rsteditcpcats['catname']?></option>
            <?php
} while ($row_rsteditcpcats = mysql_fetch_assoc($rsteditcpcats));
?>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Description of Images:</td>
          <td><input type="text" name="picalttag" value="<?php echo htmlentities($row_rsteditcp['picalttag'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        
        <tr valign="baseline">
          <td nowrap="nowrap" align="right" valign="top">Long Description:</td>
          <td><textarea name="cplongdesc" id="cplongdesc" cols="45" rows="5"><?php echo htmlentities($row_rsteditcp['cplongdesc'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
        </tr>
        
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Update record" /></td>
        </tr>
      </table>
      <input type="hidden" name="id" value="<?php echo $row_rsteditcp['id']; ?>" />
      <input type="hidden" name="MM_update" value="form1" />
      <input type="hidden" name="id" value="<?php echo $row_rsteditcp['id']; ?>" />
    </form>
    <p>&nbsp;</p>
  </div>

    
    
<div id="footer">Site Design: Patrick Moorehouse - The company Dean Electronics is owned and run by Dean Moorehouse.</div></div>
</body>
</html>
<?php
mysql_free_result($rsteditcp);

mysql_free_result($rsteditcpcats);
?>
