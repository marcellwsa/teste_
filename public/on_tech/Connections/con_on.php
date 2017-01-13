<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_con_on = "localhost";
$database_con_on = "ontech";
$username_con_on = "root";
$password_con_on = "";
$con_on = mysql_pconnect($hostname_con_on, $username_con_on, $password_con_on) or trigger_error(mysql_error(),E_USER_ERROR); 
?>