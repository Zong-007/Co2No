<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
$host = "irkm0xtlo2pcmvvz.chr7pe7iynqr.eu-west-1.rds.amazonaws.com"; // MySQL Hostname
$username = "atr8951bo6cc30cs"; // MySQL Username
$password = "qs7uojv84spfdsv6"; // MySQL Password
$dbname = "g01br52t9mmmpfah"; // ชื่อฐานข้อมูล (เปลี่ยน XXX เป็นชื่อฐานข้อมูลจริง)
$port = 3306; // MySQL Port (ค่าเริ่มต้นคือ 3306)

// สร้างการเชื่อมต่อ
$conn = new mysqli($host, $username, $password, $dbname, $port);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตั้งค่าหัวข้อ CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');

// เปิด output stream
$output = fopen('php://output', 'w');
if (!$output) {
    die("Unable to open output stream");
}

// เขียนหัวข้อคอลัมน์
fputcsv($output, array('Co2', 'Tvoc', 'day')); // เปลี่ยนชื่อคอลัมน์ตามฐานข้อมูลของคุณ

// ดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT Co2, Tvoc, day FROM co2no_data"; // แก้ไขตามตารางในฐานข้อมูลของคุณ
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // เขียนข้อมูลลงใน CSV
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
} else {
    // หากไม่มีข้อมูล
    echo "No data found";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
fclose($output);
?>
