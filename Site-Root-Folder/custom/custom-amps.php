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

mysql_select_db($database_deanelectro, $deanelectro);
$query_rstcamps = "SELECT tblcustomamps.id, tblcustomamps.caname, tblcustomamps.wattrange_id, tblcustomamps.wattage, tblcustomamps.capic, tblcustomamps.capicsmall, tblcustomamps.caprice, tblcustomamps.cadesc, tblcustomamps.capicalt, tblcustomamps.calongdesc, otblwattage.wattid, otblwattage.wattageband FROM otblwattage INNER JOIN tblcustomamps ON otblwattage.wattid = tblcustomamps.wattrange_id";
$rstcamps = mysql_query($query_rstcamps, $deanelectro) or die(mysql_error());
$row_rstcamps = mysql_fetch_assoc($rstcamps);
$totalRows_rstcamps = mysql_num_rows($rstcamps);

$query_rstcamplist = "SELECT tblcustomamps.id, tblcustomamps.caname, tblcustomamps.wattrange_id, tblcustomamps.wattage, tblcustomamps.capic, tblcustomamps.capicsmall, tblcustomamps.caprice, tblcustomamps.cadesc, tblcustomamps.capicalt, tblcustomamps.calongdesc, otblwattage.wattid, otblwattage.wattageband FROM otblwattage INNER JOIN tblcustomamps ON otblwattage.wattid = tblcustomamps.wattrange_id";
$rstcamplist = mysql_query($query_rstcamplist, $deanelectro) or die(mysql_error());
$row_rstcamplist = mysql_fetch_assoc($rstcamplist);
$totalRows_rstcamplist = mysql_num_rows($rstcamplist);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dean Electronics - Custom Amplifiers</title>
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


  <div id="mainarea">
    	
    <div id="catselect">
    <div id="cat">
      <h3>Wattage:</h3>
    </div>
    <div id="catlist">
      <ul>
      <!--    <li><a href="custom-amps-wattage.php?wattrange_id=1">&lt;2W</a></li>   -->
          <li><a href="custom-amps-wattage.php?wattid=2">2W - &lt;4W</a></li>
          <li><a href="custom-amps-wattage.php?wattid=5">10W - &lt;15W</a></li>
          <li><a href="custom-amps-wattage.php?wattid=6">20W - &lt;30W</a></li>
      </ul>
    </div>
    </div>
        
          <?php do { ?>
            <div class="caprodbox">
              <p><a href="custom-amps-details.php?id=<?php echo $row_rstcamps['id']; ?>"><?php echo $row_rstcamps['caname']; ?></a></p>
              <p>Output Power: <?php echo $row_rstcamps['wattage']; ?> Watts</p>
              <p>€<?php echo $row_rstcamps['caprice']; ?></p>
              <p><a href="custom-amps-details.php?id=<?php echo $row_rstcamps['id']; ?>"><img src="<?php echo $row_rstcamps['capicsmall']; ?>" alt="<?php echo $row_rstcamps['capicalt']; ?>" /></a></p>

              <!-- PHP If Statements Start-->
  <?php
if ($_SESSION['MM_UserGroup']==1) //admin
  {
?>
  <a href="custom-amps-editproduct.php?id=<?php echo $row_rstcamps['id']; ?>">Edit</a> - <a href="custom-amps-deleteproduct.php?id=<?php echo $row_rstcamps['id']; ?>">Delete</a>
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
            <?php } while ($row_rstcamps = mysql_fetch_assoc($rstcamps)); ?>
  </div>

  
    
<div id="footer">Site Design: Patrick Moorehouse - The company Dean Electronics is owned and run by Dean Moorehouse.</div></div>
</body>
</html>
<?php
mysql_free_result($rstcamps);
?>
