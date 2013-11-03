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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tblusers SET username=%s, fname=%s, lname=%s, dob=%s, password=%s, `role`=%s, email=%s, datejoined=%s, phone=%s WHERE userid=%s",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['fname'], "text"),
                       GetSQLValueString($_POST['lname'], "text"),
                       GetSQLValueString($_POST['dob'], "date"),
                       GetSQLValueString(md5($_POST['password']), "text"),
                       GetSQLValueString($_POST['role'], "int"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['datejoined'], "date"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['userid'], "int"));

  mysql_select_db($database_deanelectro, $deanelectro);
  $Result1 = mysql_query($updateSQL, $deanelectro) or die(mysql_error());

  $updateGoTo = "users-viewall.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rstuseredit = "-1";
if (isset($_GET['userid'])) {
  $colname_rstuseredit = $_GET['userid'];
}
mysql_select_db($database_deanelectro, $deanelectro);
$query_rstuseredit = sprintf("SELECT * FROM tblusers WHERE userid = %s", GetSQLValueString($colname_rstuseredit, "int"));
$rstuseredit = mysql_query($query_rstuseredit, $deanelectro) or die(mysql_error());
$row_rstuseredit = mysql_fetch_assoc($rstuseredit);
$totalRows_rstuseredit = mysql_num_rows($rstuseredit);

mysql_select_db($database_deanelectro, $deanelectro);
$query_rstuserrole = "SELECT * FROM otbluserroles";
$rstuserrole = mysql_query($query_rstuserrole, $deanelectro) or die(mysql_error());
$row_rstuserrole = mysql_fetch_assoc($rstuserrole);
$totalRows_rstuserrole = mysql_num_rows($rstuserrole);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dean Electronics - Edit User Details</title>
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
</head>

<body id="userspage">
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
  <h2>Edit User Details: <?php echo $row_rstuseredit['username']; ?></h2>
  

        <div id="servrepviewall">
          <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
          <table align="center">
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">First Name:</td>
                <td><input type="text" name="fname" value="<?php echo htmlentities($row_rstuseredit['fname'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
            </tr>
              <tr valign="baseline">
                <td nowrap="nowrap" align="right">Last Name:</td>
                <td><input type="text" name="lname" value="<?php echo htmlentities($row_rstuseredit['lname'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td nowrap="nowrap" align="right">Date Of Birth:</td>
                <td><input type="text" name="dob" value="<?php echo htmlentities($row_rstuseredit['dob'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td nowrap="nowrap" align="right">Password:</td>
                <td><input type="text" name="password" value="<?php echo htmlentities($row_rstuseredit['password'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td nowrap="nowrap" align="right">Role:</td>
                <td><select name="role">
                  <?php 
do {  
?>
                  <option value="<?php echo $row_rstuserrole['role_id']?>" <?php if (!(strcmp($row_rstuserrole['role_id'], htmlentities($row_rstuseredit['role'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_rstuserrole['rolename']?></option>
                  <?php
} while ($row_rstuserrole = mysql_fetch_assoc($rstuserrole));
?>
                </select></td>
              </tr>
              <tr> </tr>
              <tr valign="baseline">
                <td nowrap="nowrap" align="right">Email:</td>
                <td><input type="text" name="email" value="<?php echo htmlentities($row_rstuseredit['email'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td nowrap="nowrap" align="right">Phone:</td>
                <td><input type="text" name="phone" value="<?php echo htmlentities($row_rstuseredit['phone'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td nowrap="nowrap" align="right">&nbsp;</td>
                <td><input type="submit" value="Update record" /></td>
              </tr>
            </table>
            <input type="hidden" name="userid" value="<?php echo $row_rstuseredit['userid']; ?>" />
            <input type="hidden" name="username" value="<?php echo htmlentities($row_rstuseredit['username'], ENT_COMPAT, 'utf-8'); ?>" />
            <input type="hidden" name="datejoined" value="<?php echo htmlentities($row_rstuseredit['datejoined'], ENT_COMPAT, 'utf-8'); ?>" />
            <input type="hidden" name="MM_update" value="form1" />
            <input type="hidden" name="userid" value="<?php echo $row_rstuseredit['userid']; ?>" />
          </form>
        </div>
  </div>
  
<div id="footer">Site Design: Patrick Moorehouse - The company Dean Electronics is owned and run by Dean Moorehouse.</div></div>
</body>
</html>
<?php
mysql_free_result($rstuseredit);

mysql_free_result($rstuserrole);
?>
