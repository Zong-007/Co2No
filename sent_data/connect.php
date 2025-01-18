<?php
header('Content-Type: application/json'); // กำหนด Content-Type เป็น JSON

$host = "irkm0xtlo2pcmvvz.chr7pe7iynqr.eu-west-1.rds.amazonaws.com"; 
$username = "atr8951bo6cc30cs";
$password = "qs7uojv84spfdsv6";
$dbname = "g01br52t9mmmpfah";
$port = 3306;

$conn = new mysqli($host, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    echo json_encode(["error" => "การเชื่อมต่อฐานข้อมูลล้มเหลว"]);
    exit();
}

$sql = "SELECT Co2, Tvoc, `day` FROM co2no_data WHERE DATE(`day`) = CURDATE() ORDER BY ID DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        "Co2" => $row['Co2'],
        "Tvoc" => $row['Tvoc'],
        "Date" => $row['day']
    ]);
} else {
    echo json_encode(["error" => "ไม่พบข้อมูลในตาราง co2no_data สำหรับวันนี้"]);
}

$conn->close();
?>
