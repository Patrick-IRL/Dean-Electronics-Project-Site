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
  $insertSQL = sprintf("INSERT INTO tblampmods (id, amfname, amlname, amemail, amphone, amptomod, amdesc, amstatus, datesubmitted) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['amfname'], "text"),
                       GetSQLValueString($_POST['amlname'], "text"),
                       GetSQLValueString($_POST['amemail'], "text"),
                       GetSQLValueString($_POST['amphone'], "text"),
                       GetSQLValueString($_POST['amptomod'], "text"),
                       GetSQLValueString($_POST['amdesc'], "text"),
                       GetSQLValueString($_POST['amstatus'], "int"),
                       GetSQLValueString($_POST['datesubmitted'], "date"));

  mysql_select_db($database_deanelectro, $deanelectro);
  $Result1 = mysql_query($insertSQL, $deanelectro) or die(mysql_error());

  $insertGoTo = "thankyouampmods.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_deanelectro, $deanelectro);
$query_rstampstatus = "SELECT * FROM otblservstatus";
$rstampstatus = mysql_query($query_rstampstatus, $deanelectro) or die(mysql_error());
$row_rstampstatus = mysql_fetch_assoc($rstampstatus);
$totalRows_rstampstatus = mysql_num_rows($rstampstatus);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dean Electronics - Amplifier Mods</title>
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
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
    <h2>Amplifier Modifications</h2>
    <p>Dean Electronics offer the service of modifying your guitar amplifier. There are a tremendous amount of modifications possible, so much so that a product listing would be impossible. If you would</p>
    <div id="formsubmit">
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="left">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">First Name:</td>
          <td><span id="sprytextfield1">
          <input type="text" name="amfname" id="amfname" />
          <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMaxCharsMsg">Maximum of 30 characters.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Last Name:</td>
          <td><span id="sprytextfield2">
          <input type="text" name="amlname" id="amlname" />
          <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMaxCharsMsg">Maximum of 30 characters.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Email Address:</td>
          <td><span id="sprytextfield3">
          <input type="text" name="amemail" id="amemail" />
          <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Phone Number:</td>
          <td><span id="sprytextfield4">
          <input type="text" name="amphone" id="amphone" />
          <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Minimum of 10 characters.</span><span class="textfieldMaxCharsMsg">Maximum of 20 characters.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Amp Model:</td>
          <td><span id="sprytextfield5">
            <input type="text" name="amptomod" id="amptomod" />
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right" valign="top">Description of Modifications Required:</td>
          <td><span id="sprytextarea1">
            <textarea name="amdesc" id="amdesc" cols="45" rows="5"></textarea>
          <span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Submit Request" /></td>
        </tr>
      </table>
      <input type="hidden" name="id" value="" />
      <input type="hidden" name="amstatus" value="1" />
      <input type="hidden" name="datesubmitted" value="<?php echo date("Y-m-d"); ?>" />
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
    </div>
  </div>
<div id="footer">Site Design: Patrick Moorehouse - The company Dean Electronics is owned and run by Dean Moorehouse.</div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"], maxChars:30});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {maxChars:30, validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "email", {validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur", "change"], minChars:10, maxChars:20});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur", "change"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur", "change"]});
</script>
</body>
</html>
<?php
mysql_free_result($rstampstatus);
?>
