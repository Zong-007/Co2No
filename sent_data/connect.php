<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
$host = "irkm0xtlo2pcmvvz.chr7pe7iynqr.eu-west-1.rds.amazonaws.com"; // MySQL Hostname
$username = "atr8951bo6cc30cs"; // MySQL Username
$password = "qs7uojv84spfdsv6"; // MySQL Password
$dbname = "g01br52t9mmmpfah"; // ชื่อฐานข้อมูล
$port = 3306; // MySQL Port (ค่าเริ่มต้นคือ 3306)

// สร้างการเชื่อมต่อ
$conn = new mysqli($host, $username, $password, $dbname, $port);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// สร้างคำสั่ง SQL เพื่อดึงข้อมูลแถวที่มี ID ล่าสุด
$sql = "SELECT Co2, Tvoc, `DATE` FROM co2no_data WHERE `DATE` = CURDATE() ORDER BY ID DESC LIMIT 1";

// ส่งคำสั่ง SQL ไปยังฐานข้อมูล
$result = $conn->query($sql);

// ตัวแปรสำหรับเก็บข้อมูล
$data = array();

// ตรวจสอบว่ามีข้อมูลที่ดึงมาได้หรือไม่
if ($result->num_rows > 0) {
    // ดึงข้อมูลแถวที่มี ID ล่าสุด
    $row = $result->fetch_assoc();
    $data['Co2'] = $row['Co2'];
    $data['Tvoc'] = $row['Tvoc'];
    $data['Date'] = $row['DATE']; // วันที่
} else {
    echo "ไม่พบข้อมูลในตาราง co2no_data สำหรับวันนี้";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();

// ใช้ตัวแปร $data เพื่อนำไปแสดงผลในหน้าเว็บ
if (!empty($data)) {
    echo "Co2 (ล่าสุด): " . htmlspecialchars($data['Co2']) . "<br>";
    echo "Tvoc (ล่าสุด): " . htmlspecialchars($data['Tvoc']) . "<br>";
    echo "วันที่: " . htmlspecialchars($data['Date']) . "<br>"; // แสดงวันที่
}
?>
