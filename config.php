<?php

session_start();

$servername = "ddac-maersksql.mysql.database.azure.com";
$username = "maerskmaster@ddac-maersksql";
$password = "M@ersk121";
$dbname = "maersk";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);





