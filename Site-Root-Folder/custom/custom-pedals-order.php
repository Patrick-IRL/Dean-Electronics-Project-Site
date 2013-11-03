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
  $insertSQL = sprintf("INSERT INTO tblcustompedalorders (id, datesubmitted, cporderstatus_id, fname, lname, email, phone, cpcat_id, cppedalname, cppriceordered) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['datesubmitted'], "date"),
                       GetSQLValueString($_POST['cporderstatus_id'], "int"),
                       GetSQLValueString($_POST['fname'], "text"),
                       GetSQLValueString($_POST['lname'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['cpcat_id'], "int"),
                       GetSQLValueString($_POST['cppedalname'], "text"),
                       GetSQLValueString($_POST['cppriceordered'], "double"));

  mysql_select_db($database_deanelectro, $deanelectro);
  $Result1 = mysql_query($insertSQL, $deanelectro) or die(mysql_error());

  $insertGoTo = "thankyou.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_rstcustompedaldetails = "-1";
if (isset($_GET['id'])) {
  $colname_rstcustompedaldetails = $_GET['id'];
}
mysql_select_db($database_deanelectro, $deanelectro);
$query_rstcustompedaldetails = sprintf("SELECT tblcustompedals.id, tblcustompedals.cpname, tblcustompedals.cppic, tblcustompedals.cppicsmall, tblcustompedals.cpprice, tblcustompedals.cpdesc, tblcustompedals.cp_cat_id, tblcustompedals.cplongdesc, tblcustompedals.picalttag, otblcats.catid, otblcats.catname FROM otblcats INNER JOIN tblcustompedals ON otblcats.catid = tblcustompedals.cp_cat_id WHERE id = %s", GetSQLValueString($colname_rstcustompedaldetails, "int"));
$rstcustompedaldetails = mysql_query($query_rstcustompedaldetails, $deanelectro) or die(mysql_error());
$row_rstcustompedaldetails = mysql_fetch_assoc($rstcustompedaldetails);
$totalRows_rstcustompedaldetails = mysql_num_rows($rstcustompedaldetails);

mysql_select_db($database_deanelectro, $deanelectro);
$query_rstcporderstatus = "SELECT * FROM otblservstatus";
$rstcporderstatus = mysql_query($query_rstcporderstatus, $deanelectro) or die(mysql_error());
$row_rstcporderstatus = mysql_fetch_assoc($rstcporderstatus);
$totalRows_rstcporderstatus = mysql_num_rows($rstcporderstatus);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dean Electronics - Custom Pedals - Order Product</title>
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
   	        <th scope="col">Pedal Model</th>
   	        <th scope="col">Category</th>
   	        <th scope="col">Price</th>
        </tr>
   	      <tr>
   	        <td><?php echo $row_rstcustompedaldetails['cpname']; ?></td>
   	        <td><?php echo $row_rstcustompedaldetails['catname']; ?></td>
   	        <td><?php echo $row_rstcustompedaldetails['cpprice']; ?></td>
        </tr>
      </table>
      </div>
      <div id="formsubmit">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table align="left">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">First Name:</td>
            <td><span id="sprytextfield4">
            <input type="text" name="fname" id="fname" />
            <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMaxCharsMsg">Maximum of 30 characters.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Last Name:</td>
            <td><span id="sprytextfield3">
            <input type="text" name="lname" id="lname" />
            <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMaxCharsMsg">Maximum of 30 characters.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Email:</td>
            <td><span id="sprytextfield2">
            <input type="text" name="email" id="email" />
            <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span><span class="textfieldMaxCharsMsg">Maximum of 80 characters.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Phone:</td>
            <td><span id="sprytextfield1">
            <input type="text" name="phone" id="phone" />
            <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMaxCharsMsg">Maximum of 20 characters.</span><span class="textfieldMinCharsMsg">Minimum of 10 characters.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Insert record" /></td>
          </tr>
        </table>
        <input type="hidden" name="id" value="" />
        <input type="hidden" name="datesubmitted" value="<?php echo date("Y-m-d"); ?>" />
        <input type="hidden" name="cporderstatus_id" value="1" />
        <input type="hidden" name="cpcat_id" value="<?php echo $row_rstcustompedaldetails['cp_cat_id']; ?>" />
        <input type="hidden" name="cppedalname" value="<?php echo $row_rstcustompedaldetails['cpname']; ?>" />
        <input type="hidden" name="cppriceordered" value="<?php echo $row_rstcustompedaldetails['cpprice']; ?>" />
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
      </div>
    </div>

    
    
<div id="footer">Site Design: Patrick Moorehouse - The company Dean Electronics is owned and run by Dean Moorehouse.</div></div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"], maxChars:20, minChars:10});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "email", {validateOn:["blur", "change"], maxChars:80});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur", "change"], maxChars:30});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur", "change"], maxChars:30});
</script>
</body>
</html>
<?php
mysql_free_result($rstcustompedaldetails);

mysql_free_result($rstcporderstatus);
?>
