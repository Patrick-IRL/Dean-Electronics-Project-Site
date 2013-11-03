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
  $insertSQL = sprintf("INSERT INTO tblcontact (id, datesubmitted, statusid, fname, lname, email, phone, subject, message) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['datesubmitted'], "date"),
                       GetSQLValueString($_POST['statusid'], "int"),
                       GetSQLValueString($_POST['fname'], "text"),
                       GetSQLValueString($_POST['lname'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['subject'], "text"),
                       GetSQLValueString($_POST['message'], "text"));

  mysql_select_db($database_deanelectro, $deanelectro);
  $Result1 = mysql_query($insertSQL, $deanelectro) or die(mysql_error());

  $insertGoTo = "../custom/thankyou.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dean Electronics - Contact</title>
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>

<body id="contactpage">
<div id="wrapper" class="clearfix">
  <div id="header"> <a href="../index.php"><img src="../images/logo1.png" width="300" height="120" alt="Dean Electronics Logo" /></a>
  </div>
  
  <div id="topnav">
    <ul>
      <li><a href="../index.php">Home</a></li>
      <li><a href="../about.php">About</a></li>
      <li><a href="contact.php" id="contactlink">Contact</a></li>
      <li><a href="../mods/mods.php">Mods</a></li>
      <li><a href="../custom/custom-builds.php">Custom</a></li>
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
  <h3>Contact Dean Electronics</h3>
  <p>If you have any queries regarding any of our services or products, feel free to contact Dean Electronics by filling in and submitting the form below.</p>
  
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
        <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Phone:</td>
        <td><span id="sprytextfield4">
        <input type="text" name="phone" id="phone" />
        <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Minimum of 10 characters.</span><span class="textfieldMaxCharsMsg">Maximum of 20 characters.</span></span></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Subject:</td>
        <td><span id="sprytextfield5">
          <input type="text" name="subject" id="subject" />
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Message:</td>
        <td><span id="sprytextarea1">
          <textarea name="message" id="message" cols="45" rows="5"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td><input type="submit" value="Submit" /></td>
      </tr>
    </table>
    <input type="hidden" name="id" value="" />
    <input type="hidden" name="datesubmitted" value="<?php echo date("Y-m-d"); ?>" />
    <input type="hidden" name="statusid" value="1" />
    <input type="hidden" name="MM_insert" value="form1" />
</form>
	</div>
<!-- Inserting Google Maps Code Here -->
<iframe width="768" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=51.887644,-8.403168&amp;spn=0.003576,0.010568&amp;t=m&amp;z=17&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=51.887644,-8.403168&amp;spn=0.003576,0.010568&amp;t=m&amp;z=17&amp;source=embed" style="color:#0000FF;text-align:left">View Larger Map</a></small>
<!-- End of Google Maps Code -->
  </div>
   
<div id="footer">Site Design: Patrick Moorehouse - The company Dean Electronics is owned and run by Dean Moorehouse.</div></div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"], maxChars:30});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"], maxChars:30});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "email", {validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur", "change"], minChars:10, maxChars:20});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur", "change"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur", "change"]});
</script>
</body>
</html>