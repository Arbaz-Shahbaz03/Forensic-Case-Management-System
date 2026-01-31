<?php
// Database connection settings
$host = "oracledb";  // this is the service name from docker-compose
$port = "1521";
$sid  = "XE";
$username = "ARBAZ";
$password = "arbazbazi1122";

// Build connection string
$connection_string = "(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port))
    (CONNECT_DATA = (SERVER = DEDICATED)(SERVICE_NAME = $sid))
)";

$conn = oci_connect($username, $password, $connection_string);

if (!$conn) {
    $e = oci_error();
    echo "<h2>❌ Oracle Connection Failed:</h2>";
    echo htmlentities($e['message']);
} else {
    echo "<h2>✅ Connection Successful!</h2>";
}

?>
