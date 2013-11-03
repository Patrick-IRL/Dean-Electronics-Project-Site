<?php require_once('../Connections/deanelectro.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
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

$colname_rstpedalbrand = "-1";
if (isset($_GET['brandid'])) {
  $colname_rstpedalbrand = $_GET['brandid'];
}
mysql_select_db($database_deanelectro, $deanelectro);
$query_rstpedalbrand = sprintf("SELECT p.*, b.`brandname` AS `brand_name`, c.* FROM `tblpedals` AS p JOIN `otblbrand` AS b     ON p.`brand_id` = b.`brandid` JOIN `otblcats` AS c     ON p.`cat_id` = c.`catid` WHERE b.`brandid` = %s", GetSQLValueString($colname_rstpedalbrand, "int"));
$rstpedalbrand = mysql_query($query_rstpedalbrand, $deanelectro) or die(mysql_error());
$row_rstpedalbrand = mysql_fetch_assoc($rstpedalbrand);
$totalRows_rstpedalbrand = mysql_num_rows($rstpedalbrand);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dean Electronics - Pedal Mods</title>
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
  
  
        
          <?php do { ?>
            <div class="prodbox">
              <p><a href="mods-pedals-details.php?pedalid=<?php echo $row_rstpedalbrand['pedalid']; ?>"><?php echo $row_rstpedalbrand['pedalname']; ?></a></p>
              <p> €<?php echo $row_rstpedalbrand['price']; ?></p>
              <p><a href="mods-pedals-details.php?pedalid=<?php echo $row_rstpedalbrand['pedalid']; ?>"><img src="<?php echo $row_rstpedalbrand['picsmall']; ?>" /></a></p>
              <p><?php echo $row_rstpedalbrand['brand_name']; ?> - <?php echo $row_rstpedalbrand['catname']; ?></p>

<!-- PHP If Statements Start-->
<?php
if ($_SESSION['MM_UserGroup']==1) //admin
  {
?>
     <a href="mods-pedals-editproduct.php?pedalid=<?php echo $row_rstpedalbrand['pedalid']; ?>">Edit</a> - <a href="mods-pedals-editproduct.php?pedalid=<?php echo $row_rstpedalbrand['pedalid']; ?>">Delete</a>
<?php
  }
else
  {
?>
<?php
  }
?>
<!-- PHP If Statements End-->




			</div>
            <?php } while ($row_rstpedalbrand = mysql_fetch_assoc($rstpedalbrand)); ?>
<div id="footer">Site Design: Patrick Moorehouse - The company Dean Electronics is owned and run by Dean Moorehouse.</div></div>
</body>
</html>
<?php
mysql_free_result($rstpedalbrand);
?>
