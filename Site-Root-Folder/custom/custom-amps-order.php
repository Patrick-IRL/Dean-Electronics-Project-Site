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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tblcustomamporders (id, datesubmitted, caorderstatus_id, fname, lname, email, phone, watt_id, campname, camppriceordered) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['datesubmitted'], "date"),
                       GetSQLValueString($_POST['caorderstatus_id'], "int"),
                       GetSQLValueString($_POST['fname'], "text"),
                       GetSQLValueString($_POST['lname'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['watt_id'], "int"),
                       GetSQLValueString($_POST['campname'], "text"),
                       GetSQLValueString($_POST['camppriceordered'], "double"));

  mysql_select_db($database_deanelectro, $deanelectro);
  $Result1 = mysql_query($insertSQL, $deanelectro) or die(mysql_error());

  $insertGoTo = "thankyou.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_rstcamporders = "-1";
if (isset($_GET['id'])) {
  $colname_rstcamporders = $_GET['id'];
}
mysql_select_db($database_deanelectro, $deanelectro);
$query_rstcamporders = sprintf("SELECT tblcustomamps.id, tblcustomamps.caname, tblcustomamps.wattrange_id, tblcustomamps.wattage, tblcustomamps.capic, tblcustomamps.capicsmall, tblcustomamps.caprice, tblcustomamps.cadesc, tblcustomamps.capicalt, tblcustomamps.calongdesc, otblwattage.wattid, otblwattage.wattageband FROM otblwattage INNER JOIN tblcustomamps ON otblwattage.wattid = tblcustomamps.wattrange_id WHERE id = %s", GetSQLValueString($colname_rstcamporders, "int"));
$rstcamporders = mysql_query($query_rstcamporders, $deanelectro) or die(mysql_error());
$row_rstcamporders = mysql_fetch_assoc($rstcamporders);
$totalRows_rstcamporders = mysql_num_rows($rstcamporders);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dean Electronics - Custom Amplifiers - Order Product</title>
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
   	  <h2>Order Submission </h2>
      
     <div id="orderreview">
      <table width="768" border="1" cellspacing="3" cellpadding="3">
   	      <tr>
   	        <th scope="col">Amp Model</th>
   	        <th scope="col">Wattage</th>
   	        <th scope="col">Price</th>
        </tr>
   	      <tr>
   	        <td><?php echo $row_rstcamporders['caname']; ?></td>
   	        <td><?php echo $row_rstcamporders['wattage']; ?></td>
   	        <td><?php echo $row_rstcamporders['caprice']; ?></td>
        </tr>
      </table>
      </div>
      <div id="formsubmit">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table align="left">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">First Name:</td>
            <td><span id="sprytextfield1">
            <input type="text" name="fname" id="fname" />
            <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMaxCharsMsg">Maximum of 30 characters.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Last Name:</td>
            <td><span id="sprytextfield2">
            <input type="text" name="lname" id="lname" />
            <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMaxCharsMsg">Maximum of 30 characters.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Email:</td>
            <td><span id="sprytextfield3">
            <input type="text" name="email" id="email" />
            <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMaxCharsMsg">Maximum of 80 characters.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Phone:</td>
            <td><span id="sprytextfield4">
            <input type="text" name="phone" id="phone" />
            <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Minimum of 10 characters.</span><span class="textfieldMaxCharsMsg">Maximum of 20 characters.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Submit Order" /></td>
          </tr>
        </table>
        <input type="hidden" name="id" value="" />
        <input type="hidden" name="datesubmitted" value="<?php echo date("Y-m-d"); ?>" />
        <input type="hidden" name="caorderstatus_id" value="1" />
        <input type="hidden" name="watt_id" value="<?php echo $row_rstcamporders['wattrange_id']; ?>" />
        <input type="hidden" name="campname" value="<?php echo $row_rstcamporders['caname']; ?>" />
        <input type="hidden" name="camppriceordered" value="<?php echo $row_rstcamporders['caprice']; ?>" />
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
      </div>
    </div>

    
    
<div id="footer">Site Design: Patrick Moorehouse - The company Dean Electronics is owned and run by Dean Moorehouse.</div></div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"], maxChars:30});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"], maxChars:30});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "email", {validateOn:["blur", "change"], maxChars:80});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur", "change"], minChars:10, maxChars:20});
</script>
</body>
</html>
<?php
mysql_free_result($rstcamporders);
?>
