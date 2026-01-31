<?php
header("Content-Type: application/json");

$conn = oci_connect("system", "admin", "oracle11g:1521/XE");

if (!$conn) {
    $e = oci_error();
    echo json_encode(["error" => $e['message']]);
    exit;
}

$sql = "SELECT * FROM CASES_TABLE ORDER BY DATE_FILED DESC";
$stmt = oci_parse($conn, $sql);
oci_execute($stmt);

$cases = [];
while ($row = oci_fetch_assoc($stmt)) {
    $cases[] = $row;
}

echo json_encode($cases);

oci_close($conn);
?>
