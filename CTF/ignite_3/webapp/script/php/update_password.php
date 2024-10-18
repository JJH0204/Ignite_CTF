<?php
// update_password.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // 모든 도메인 허용
$input = json_decode(file_get_contents('php://input'), true);
$username = $input['username'];
$newPassword = $input['newPassword'];

// user.json 파일 업데이트
$jsonFile = 'json/users.json';
$jsonData = json_decode(file_get_contents($jsonFile), true);

foreach ($jsonData as &$user) {
    if ($user['username'] === $username) {
        $user['password'] = $newPassword;
        break;
    }
}

file_put_contents($jsonFile, json_encode($jsonData, JSON_PRETTY_PRINT));

// MySQL 데이터베이스 업데이트
$servername = "localhost";
$dbUsername = "root"; // DB 사용자명
$dbPassword = "1515"; // DB 비밀번호
$dbName = "GameDB"; // DB 이름

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    echo json_encode(['message' => 'DB 연결 실패: ' . $conn->connect_error]);
    exit();
}

// 비밀번호 업데이트 쿼리
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
$stmt->bind_param('ss', $newPassword, $username);

if ($stmt->execute()) {
    echo json_encode(['message' => '비밀번호가 성공적으로 재설정되었습니다.']);
} else {
    echo json_encode(['message' => '비밀번호 재설정 실패.']);
}

$stmt->close();
$conn->close();
?>
