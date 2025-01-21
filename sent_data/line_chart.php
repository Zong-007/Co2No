<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// กำหนด Content-Type เป็น JSON
header('Content-Type: application/json');

$host = "irkm0xtlo2pcmvvz.chr7pe7iynqr.eu-west-1.rds.amazonaws.com"; 
$username = "atr8951bo6cc30cs";
$password = "qs7uojv84spfdsv6";
$dbname = "g01br52t9mmmpfah";
$port = 3306;

// สร้างการเชื่อมต่อฐานข้อมูล
$conn = new mysqli($host, $username, $password, $dbname, $port);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    echo json_encode(["error" => "การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error]);
    exit();
}

// คำสั่ง SQL สำหรับดึงข้อมูลภายใน 24 ชั่วโมงและแยกตามชั่วโมง
$sql_last_24_hours = "
    SELECT 
        DATE_FORMAT(`day`, '%Y-%m-%d %H:00:00') AS hour,  -- แยกตามชั่วโมง
        AVG(Co2) AS avg_Co2  -- ค่าเฉลี่ยของ Co2
    FROM 
        co2no_data
    WHERE 
        `day` >= CURDATE() - INTERVAL 1 DAY  -- ดึงข้อมูลจาก 24 ชั่วโมงที่ผ่านมา
    GROUP BY 
        hour  -- แบ่งข้อมูลตามชั่วโมง
    ORDER BY 
        `day` DESC  -- เรียงข้อมูลจากเวลาล่าสุด
";

// ดำเนินการคำสั่ง SQL
$result_last_24_hours = $conn->query($sql_last_24_hours);

// ตัวแปรสำหรับเก็บข้อมูล
$response = [];

// ตัวแปรสำหรับเก็บข้อมูล 24 ชั่วโมง
$last_24_hours_data = [];

// สร้าง array สำหรับช่วงเวลาทั้ง 24 ชั่วโมง (แบ่งเป็นชั่วโมง)
$dates = [];
for ($i = 0; $i < 24; $i++) {
    $dates[] = date('Y-m-d H:00:00', strtotime('-' . $i . ' hours'));
}

// ตรวจสอบผลลัพธ์ของข้อมูลใน 24 ชั่วโมง
while ($row = $result_last_24_hours->fetch_assoc()) {
    // เช็คว่า "hour" อยู่ใน $dates หรือไม่
    $hour = $row['hour'];
    if (in_array($hour, $dates)) {
        // เพิ่มข้อมูลสำหรับชั่วโมงที่มีในฐานข้อมูล
        $last_24_hours_data[$hour] = [
            'hour' => $hour,
            'Co2_G' => round($row['avg_Co2'], 2)  // เปลี่ยนจาก Spo2_G เป็น Co2_G
        ];
    }
}

// เพิ่มข้อมูลสำหรับชั่วโมงที่ไม่มีข้อมูลจากฐานข้อมูลเป็นค่า 0
foreach ($dates as $hour) {
    if (!isset($last_24_hours_data[$hour])) {
        $last_24_hours_data[$hour] = [
            'hour' => $hour,
            'Co2_G' => 0  // เปลี่ยนจาก Spo2_G เป็น Co2_G
        ];
    }
}

// เรียงข้อมูลจากชั่วโมงล่าสุด
ksort($last_24_hours_data);

// เพิ่มข้อมูล 24 ชั่วโมงใน response
$response['last_24_hours'] = array_values($last_24_hours_data);

// ส่งข้อมูลในรูปแบบ JSON
echo json_encode($response);

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
