<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
$host = "irkm0xtlo2pcmvvz.chr7pe7iynqr.eu-west-1.rds.amazonaws.com"; // MySQL Hostname
$username = "atr8951bo6cc30cs"; // MySQL Username
$password = "qs7uojv84spfdsv6"; // MySQL Password
$dbname = "g01br52t9mmmpfah"; // ชื่อฐานข้อมูล (เปลี่ยน XXX เป็นชื่อฐานข้อมูลจริง)
$port = 3306; // MySQL Port (ค่าเริ่มต้นคือ 3306)

// สร้างการเชื่อมต่อ
$conn = new mysqli($host, $username, $password, $dbname, $port);


?>
