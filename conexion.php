<?php
$servername = "162.214.97.208:3306";
$username ="vdnsjf_fabian";
$password ="Fabian253107.";
$dbname = "vdnsjf_portalvdn3";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    $currentDateTime = date('Y-m-d H:i:s');
    error_log($currentDateTime." BD-Connection-ERROR: " . $conn->connect_error . "\n", 3, dirname(__FILE__) . "/error.log.txt");
    die("Connection failed: " . $conn->connect_error);
  }
  echo "Connected successfully";
