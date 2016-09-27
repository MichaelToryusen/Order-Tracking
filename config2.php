<?Php
$servername = "10.0.0.0";
$username = "username";
$password = "password";
$dbname = "Denton_Multi";
$link = mssql_connect($servername, $username, $password);
 
if (!mssql_select_db($dbname, $link))
    die('Unable to select database!');
?> 
