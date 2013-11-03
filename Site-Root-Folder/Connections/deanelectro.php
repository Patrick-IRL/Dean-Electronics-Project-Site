<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_deanelectro = "OMITTED";
$database_deanelectro = "OMITTED";
$username_deanelectro = "OMITTED";
$password_deanelectro = "OMITTED";
$deanelectro = mysql_pconnect($hostname_deanelectro, $username_deanelectro, $password_deanelectro) or trigger_error(mysql_error(),E_USER_ERROR); 
?>