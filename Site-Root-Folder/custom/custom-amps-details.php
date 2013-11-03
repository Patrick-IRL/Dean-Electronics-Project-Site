<?php require_once('../Connections/deanelectro.php'); ?>
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

$colname_rstcampdetails = "-1";
if (isset($_GET['id'])) {
  $colname_rstcampdetails = $_GET['id'];
}
mysql_select_db($database_deanelectro, $deanelectro);
$query_rstcampdetails = sprintf("SELECT tblcustomamps.id, tblcustomamps.caname, tblcustomamps.wattrange_id, tblcustomamps.wattage, tblcustomamps.capic, tblcustomamps.capicsmall, tblcustomamps.caprice, tblcustomamps.cadesc, tblcustomamps.capicalt, tblcustomamps.calongdesc, otblwattage.wattid, otblwattage.wattageband FROM otblwattage INNER JOIN tblcustomamps ON otblwattage.wattid = tblcustomamps.wattrange_id WHERE id = %s", GetSQLValueString($colname_rstcampdetails, "int"));
$rstcampdetails = mysql_query($query_rstcampdetails, $deanelectro) or die(mysql_error());
$row_rstcampdetails = mysql_fetch_assoc($rstcampdetails);
$totalRows_rstcampdetails = mysql_num_rows($rstcampdetails);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dean Electronics - Custom Amplifiers - Product Details</title>
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
      <li><a href="../custom/custom-amps.php">Amplifiers</a></li>
    </ul>
    <h3>Repairs and Servicing</h3>
    <ul>
      <li><a href="../repairsandservices/repairs-servicing.php">Services and Repairs</a></li>
    </ul>
  </div>
  
  <div id="productarea">
    <div id="prodtitle"><?php echo $row_rstcampdetails['caname']; ?></div>
    <div id="prodprice">€<?php echo $row_rstcampdetails['caprice']; ?></div>
    <div id="prodmake">Dean Electronics</div>
    <div id="prodcat"><?php echo $row_rstcampdetails['wattage']; ?> Watt(s)</div>
    <div id="prodpic"><img src="<?php echo $row_rstcampdetails['capic']; ?>" alt="<?php echo $row_rstcampdetails['capicalt']; ?>" /></div>
    <div id="prodinfo"><?php echo $row_rstcampdetails['cadesc']; ?></div>
    <div id="prodlongdesc"><?php echo $row_rstcampdetails['calongdesc']; ?></div>
    
        <!-- PHP If Statements Start-->
    <div id="orderitem">
<?php
if ($_SESSION['MM_UserGroup']==1) //admin
  {
?>
     <a href="custom-amps-editproduct.php?id=<?php echo $row_rstcampdetails['id']; ?>">Edit</a> - <a href="custom-amps-deleteproduct.php?id=<?php echo $row_rstcampdetails['id']; ?>">Delete</a>
<?php
  }
else
  {
?>
	<a href="custom-amps-order.php?id=<?php echo $row_rstcampdetails['id']; ?>">Order This Item</a>
<?php
  }
?>
	</div>
<!-- PHP If Statements End-->

    
  </div>
    

    
    
<div id="footer">Site Design: Patrick Moorehouse - The company Dean Electronics is owned and run by Dean Moorehouse.</div></div>
</body>
</html>
<?php
mysql_free_result($rstcampdetails);
?>
