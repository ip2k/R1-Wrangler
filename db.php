<?php
include 'config.php';
// DB CONNECTION
$conn = mysql_connect($config['dbHost'], $config['dbUser'], $config['dbPass']) or die ('Error connecting to mysql');
mysql_select_db($config['dbName']);
?>
