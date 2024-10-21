<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // 임시로 모든 도메인 허용 (필요에 따라 수정)

// 입력 데이터 읽기
$input = json_decode(file_get_contents('php://input'), true);
$username = $input['username'] ?? null;
$newPassword = $input['newPassword'] ?? null;

if (!$username || !$newPassword) {
    echo json_encode(['message' => '유효하지 않은 입력입니다.']);
    exit();
}

// 비밀번호 해시 생성
$newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);

// DB 연결
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "1515";
$dbName = "GameDB";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    echo json_encode(['message' => 'DB 연결 실패: ' . $conn->connect_error]);
    exit();
}

// 비밀번호 업데이트 쿼리 실행
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
$stmt->bind_param('ss', $newPasswordHash, $username);

if ($stmt->execute()) {
    echo json_encode(['message' => '비밀번호가 성공적으로 재설정되었습니다.']);
} else {
    echo json_encode(['message' => '비밀번호 재설정 실패: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
