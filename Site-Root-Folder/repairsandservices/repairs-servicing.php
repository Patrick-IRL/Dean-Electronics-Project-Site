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
  $insertSQL = sprintf("INSERT INTO tblservrep (id, srfname, srlname, sremail, srphone, servrep, servtype, srdesc, srstatus, datesubmitted) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['srfname'], "text"),
                       GetSQLValueString($_POST['srlname'], "text"),
                       GetSQLValueString($_POST['sremail'], "text"),
                       GetSQLValueString($_POST['srphone'], "text"),
                       GetSQLValueString($_POST['servrep'], "int"),
                       GetSQLValueString($_POST['servtype'], "int"),
                       GetSQLValueString($_POST['srdesc'], "text"),
                       GetSQLValueString($_POST['srstatus'], "int"),
                       GetSQLValueString($_POST['datesubmitted'], "date"));

  mysql_select_db($database_deanelectro, $deanelectro);
  $Result1 = mysql_query($insertSQL, $deanelectro) or die(mysql_error());

  $insertGoTo = "thankyou.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}





mysql_select_db($database_deanelectro, $deanelectro);
$query_rstserorrep = "SELECT * FROM otblservorrep";
$rstserorrep = mysql_query($query_rstserorrep, $deanelectro) or die(mysql_error());
$row_rstserorrep = mysql_fetch_assoc($rstserorrep);
$totalRows_rstserorrep = mysql_num_rows($rstserorrep);

mysql_select_db($database_deanelectro, $deanelectro);
$query_rstservreptype = "SELECT * FROM otblservtype";
$rstservreptype = mysql_query($query_rstservreptype, $deanelectro) or die(mysql_error());
$row_rstservreptype = mysql_fetch_assoc($rstservreptype);
$totalRows_rstservreptype = mysql_num_rows($rstservreptype);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dean Electronics - Servicing and Repairs</title>
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>

<body id="servreppage">
<div id="wrapper" class="clearfix">
  <div id="header"> <a href="../index.php"><img src="../images/logo1.png" width="300" height="120" alt="Dean Electronics Logo" /></a>
  </div>
  
   <div id="topnav">
    <ul>
      <li><a href="../index.php">Home</a></li>
      <li><a href="../about.php">About</a></li>
      <li><a href="../contact/contact.php">Contact</a></li>
      <li><a href="../mods/mods.php">Mods</a></li>
      <li><a href="../custom/custom-builds.php">Custom</a></li>
      <li><a href="../repairsandservices/repairs-servicing.php" id="servreplink">Repairs And Services</a></li>
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
  <h2>Servicing and Repair Requests</h2>
  
    <p>Dean Electronics offer servicing and repairs. If you would like your equipment repaired, submit the form below, filling out all the relevant information, choosing Repair from the drop down menu, and choose which of the three categories of equipment you need to get repaired. Iclude a description of what needs to be repaired and any information you can provide on the issue.</p>
    <p>If you require equipment servicing, Dean Electronics can take care of this also. This would involve replacing old parts and general maintenance on equipment that is in proper functioning order, even if it does require a little TLC. Simply choose Servicing from the drop down menu and provide details on the kind of servicing your gear requires.</p>
    <p>Once you have submitted your request, we will contact you via the email address you have provided as soon as we can to discuss further the services you require and to make the appropriate arrangements.</p>
    <p>&nbsp;</p>
    
    <div id="formsubmit">
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="left">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">First Name:</td>
          <td><span id="sprytextfield4">
          <input type="text" name="srfname" id="srfname" />
          <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMaxCharsMsg">Maximum  of 20 characters.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Last Name:</td>
          <td><span id="sprytextfield3">
          <input type="text" name="srlname" id="srlname" />
          <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMaxCharsMsg">Maximum of 20 characters.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Email Address:</td>
          <td><span id="sprytextfield2">
          <input type="text" name="sremail" id="sremail" />
          <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Phone Number:</td>
          <td><span id="sprytextfield1">
          <input type="text" name="srphone" id="srphone" />
          <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Minimum of 10characters.</span><span class="textfieldMaxCharsMsg">Maximum of 20characters.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Service or Repair&gt;:</td>
          <td><select name="servrep">
            <?php 
do {  
?>
            <option value="<?php echo $row_rstserorrep['id']?>" ><?php echo $row_rstserorrep['servorrepname']?></option>
            <?php
} while ($row_rstserorrep = mysql_fetch_assoc($rstserorrep));
?>
          </select></td>
        </tr>
        
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Category:</td>
          <td><select name="servtype">
            <?php 
do {  
?>
            <option value="<?php echo $row_rstservreptype['servtype_id']?>" ><?php echo $row_rstservreptype['servtype']?></option>
            <?php
} while ($row_rstservreptype = mysql_fetch_assoc($rstservreptype));
?>
          </select></td>
        </tr>
        
        <tr valign="baseline">
          <td nowrap="nowrap" align="right" valign="top">Describe Your Needs:</td>
          <td><span id="sprytextarea1">
            <textarea name="srdesc" id="srdesc" cols="45" rows="5"></textarea>
          <span id="countsprytextarea1">&nbsp;</span><span class="textareaRequiredMsg">A value is required.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Submit Request" /></td>
        </tr>
      </table>
      <input type="hidden" name="id" value="" />
      <input type="hidden" name="srstatus" value="1" />
      <input type="hidden" name="datesubmitted" value="<?php echo date("Y-m-d"); ?>" />
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
    
    </div>
  </div>
<div id="footer">Site Design: Patrick Moorehouse - The company Dean Electronics is owned and run by Dean Moorehouse.</div></div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:10, maxChars:20, validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "email", {validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {maxChars:20, validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur", "change"], maxChars:20});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur", "change"], counterId:"countsprytextarea1"});
</script>
</body>
</html>
<?php
mysql_free_result($rstserorrep);

mysql_free_result($rstservreptype);
?>
