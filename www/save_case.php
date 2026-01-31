<?php
header("Content-Type: application/json");

$conn = oci_connect("system", "admin", "oracle11g:1521/XE");

if (!$conn) {
    $e = oci_error();
    echo json_encode(["error" => $e['message']]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$sql = "INSERT INTO CASES_TABLE 
        (CASE_ID, TITLE, TYPE, LEAD_OFFICER, STATUS, DESCRIPTION, EVIDENCE, DATE_FILED)
        VALUES (:id, :title, :type, :lead, :status, :desc, :evidence, TO_DATE(:date, 'YYYY-MM-DD'))";

$stmt = oci_parse($conn, $sql);

foreach ($data as $key => $value) {
    oci_bind_by_name($stmt, ":$key", $data[$key]);
}

$r = oci_execute($stmt);

echo json_encode(["success" => $r]);

oci_close($conn);
?>
