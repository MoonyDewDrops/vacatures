<?php
// Don't start session here - let pages handle it themselves

$dbhost = "localhost";
$dbuser = "bureau_vacatures";
$dbpass = "rXSnkLxqWSVWPjSTRMMF";
$dbname = "bureau_vacatures";

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $conn->connect_error;
    exit();
}