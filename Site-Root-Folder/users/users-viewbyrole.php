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

$colname_rstusersbyrole = "-1";
if (isset($_GET['role_id'])) {
  $colname_rstusersbyrole = $_GET['role_id'];
}
mysql_select_db($database_deanelectro, $deanelectro);
$query_rstusersbyrole = sprintf("SELECT u.*, r.* FROM tblusers AS u JOIN otbluserroles AS r ON u.`role` = r.`role_id` WHERE role_id = %s", GetSQLValueString($colname_rstusersbyrole, "int"));
$rstusersbyrole = mysql_query($query_rstusersbyrole, $deanelectro) or die(mysql_error());
$row_rstusersbyrole = mysql_fetch_assoc($rstusersbyrole);
$totalRows_rstusersbyrole = mysql_num_rows($rstusersbyrole);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dean Electronics - View Users</title>
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
  <h2>Users</h2>
  <p>Sort by Role: </p>
  <ul>
    <li><a href="users-viewbyrole.php?role_id=1">Admin</a></li>
    <li><a href="users-viewbyrole.php?role_id=2">SuperUser</a></li>
    <li><a href="users-viewbyrole.php?role_id=3">User</a></li>
  </ul>

        <?php do { ?>
          <div id="adminlistview">
            <table width="748" border="1" cellspacing="3" cellpadding="3">
              <tr>
                <th scope="row">User ID</th>
                <td><?php echo $row_rstusersbyrole['userid']; ?></td>
              </tr>
              <tr>
                <th scope="row">Username</th>
                <td><?php echo $row_rstusersbyrole['username']; ?></td>
              </tr>
              <tr>
                <th scope="row">Date Joined</th>
                <td><?php echo $row_rstusersbyrole['datejoined']; ?></td>
              </tr>
              <tr>
                <th scope="row">First Name</th>
                <td><?php echo $row_rstusersbyrole['fname']; ?></td>
              </tr>
              <tr>
                <th scope="row">Last Name</th>
                <td><?php echo $row_rstusersbyrole['lname']; ?></td>
              </tr>
              <tr>
                <th scope="row">Email</th>
                <td><?php echo $row_rstusersbyrole['email']; ?></td>
              </tr>
              <tr>
                <th scope="row">Phone</th>
                <td><?php echo $row_rstusersbyrole['phone']; ?></td>
              </tr>
              <tr>
                <th scope="row">Date Of Birth</th>
                <td><?php echo $row_rstusersbyrole['dob']; ?></td>
              </tr>
              <tr>
                <th scope="row">Role</th>
                <td><?php echo $row_rstusersbyrole['rolename']; ?></td>
              </tr>
              <tr>
                <th scope="row">Moderate</th>
                <td><a href="users-edit.php?userid=<?php echo $row_rstusersbyrole['userid']; ?>">Edit</a> - <a href="users-delete.php?userid=<?php echo $row_rstusersbyrole['userid']; ?>">Delete</a></td>
              </tr>
            </table>
            </div>
          <?php } while ($row_rstusersbyrole = mysql_fetch_assoc($rstusersbyrole)); ?>
  </div>
  
<div id="footer">Site Design: Patrick Moorehouse - The company Dean Electronics is owned and run by Dean Moorehouse.</div></div>
</body>
</html>
<?php
mysql_free_result($rstusersbyrole);
?>
