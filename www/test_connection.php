<?php
$host = "localhost";
$port = "1521";
$sid  = "XE";

$dsn = "(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port))
    (CONNECT_DATA = (SERVER = DEDICATED)(SERVICE_NAME = $sid))
)";

$username = "ARBAZ";
$password = "arbazbazi1122";

$conn = oci_connect($username, $password, $dsn);

if (!$conn) {
    $e = oci_error();
    echo "Connection Failed: " . $e['message'];
} else {
    echo "Connected to Oracle XE Successfully!";
}
?>
