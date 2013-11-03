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

$colname_rstcustompedalsbycat = "-1";
if (isset($_GET['catid'])) {
  $colname_rstcustompedalsbycat = $_GET['catid'];
}
mysql_select_db($database_deanelectro, $deanelectro);
$query_rstcustompedalsbycat = sprintf("SELECT tblcustompedals.id, tblcustompedals.cpname, tblcustompedals.cppic, tblcustompedals.cppicsmall, tblcustompedals.cpprice, tblcustompedals.cpdesc, tblcustompedals.cp_cat_id, tblcustompedals.cplongdesc, tblcustompedals.picalttag, otblcats.catid, otblcats.catname FROM otblcats INNER JOIN tblcustompedals ON otblcats.catid = tblcustompedals.cp_cat_id WHERE catid = %s", GetSQLValueString($colname_rstcustompedalsbycat, "int"));
$rstcustompedalsbycat = mysql_query($query_rstcustompedalsbycat, $deanelectro) or die(mysql_error());
$row_rstcustompedalsbycat = mysql_fetch_assoc($rstcustompedalsbycat);
$totalRows_rstcustompedalsbycat = mysql_num_rows($rstcustompedalsbycat);

mysql_select_db($database_deanelectro, $deanelectro);
$query_rstcategorylist = "SELECT * FROM otblcats ORDER BY catname ASC";
$rstcategorylist = mysql_query($query_rstcategorylist, $deanelectro) or die(mysql_error());
$row_rstcategorylist = mysql_fetch_assoc($rstcategorylist);
$totalRows_rstcategorylist = mysql_num_rows($rstcategorylist);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dean Electronics - Custom Pedals</title>
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
      <h3>Categories:</h3>
    </div>
    <div id="catlist">
      <ul>
          <li><a href="cutsom-pedals-category.php?catid=5">Overdrive</a></li>
          <li><a href="cutsom-pedals-category.php?catid=2">Compression</a></li>
          <li><a href="cutsom-pedals-category.php?catid=7">Modulation</a></li>
          <li><a href="cutsom-pedals-category.php?catid=6">Wah/filter</a></li>
      </ul>
    </div>
    
    </div>
      <?php do { ?>
        <div class="prodbox">
            <p><a href="custom-pedals-details.php?id=<?php echo $row_rstcustompedalsbycat['id']; ?>"><?php echo $row_rstcustompedalsbycat['cpname']; ?></a></p>
            <p><?php echo $row_rstcustompedalsbycat['catname']; ?></p>
            <p>€<?php echo $row_rstcustompedalsbycat['cpprice']; ?></p>
            <p><a href="custom-pedals-details.php?id=<?php echo $row_rstcustompedalsbycat['id']; ?>"><img src="<?php echo $row_rstcustompedalsbycat['cppicsmall']; ?>" alt="<?php echo $row_rstcustompedalsbycat['picalttag']; ?>" /></a></p>
        
                      <!-- PHP If Statements Start-->
  <?php
if ($_SESSION['MM_UserGroup']==1) //admin
  {
?>
              <a href="custom-pedals-editproduct.php?id=<?php echo $row_rstcustompedalsbycat['id']; ?>">Edit</a> - <a href="custom-pedals-deleteproduct.php?id=<?php echo $row_rstcustompedalsbycat['id']; ?>">Delete</a>
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
          <?php } while ($row_rstcustompedalsbycat = mysql_fetch_assoc($rstcustompedalsbycat)); ?>
  </div>

  
    
<div id="footer">Site Design: Patrick Moorehouse - The company Dean Electronics is owned and run by Dean Moorehouse.</div></div>
</body>
</html>
<?php
mysql_free_result($rstcustompedalsbycat);

mysql_free_result($rstcategorylist);
?>
