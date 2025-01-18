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

// สร้างคำสั่ง SQL เพื่อดึงข้อมูลเฉพาะวันที่ปัจจุบัน
$sql = "SELECT Co2, Tvoc FROM co2no_data WHERE DATE(created_at) = CURDATE()";

// ส่งคำสั่ง SQL ไปยังฐานข้อมูล
$result = $conn->query($sql);

// ตัวแปรสำหรับเก็บข้อมูล
$data = array();

// ตรวจสอบว่ามีข้อมูลที่ดึงมาได้หรือไม่
if ($result->num_rows > 0) {
    // เก็บข้อมูลในตัวแปร $data
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            'Co2' => $row['Co2'],
            'Tvoc' => $row['Tvoc']
        );
    }
} else {
    echo "ไม่พบข้อมูลในตาราง co2no_data สำหรับวันนี้";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();

// ใช้ตัวแปร $data เพื่อนำไปแสดงผลในหน้าเว็บ
?>