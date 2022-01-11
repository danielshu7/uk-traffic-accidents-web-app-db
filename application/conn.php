<?php

$dbhost = '127.0.0.1'; // localhost
$dbuname = 'root';
$dbpass = ''; // need 'root' if mac?
$dbname = 'collisions'; //Database name


//$dbo = new PDO('mysql:host=abc.com;port=8889;dbname=$dbname, $dbuname, $dbpass);
// different port for mac?
$dbo = new PDO('mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname, $dbuname, $dbpass);

?>
