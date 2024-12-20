<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // 모든 도메인 허용

// 입력 데이터 파싱
$input = json_decode(file_get_contents('php://input'), true);
$username = $input['username'];
$newPassword = $input['newPassword'];

// MySQL 데이터베이스 연결 정보
$servername = "localhost";
$dbUsername = "root"; // DB 사용자명
$dbPassword = "i0oH3aemxD7T71tPr1nK"; // DB 비밀번호
$dbName = "adminDB"; // DB 이름

// MySQL 연결
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// 연결 오류 처리
if ($conn->connect_error) {
    echo json_encode(['message' => 'DB 연결 실패: ' . $conn->connect_error]);
    exit();
}

// 비밀번호 업데이트 쿼리 준비
$stmt = $conn->prepare("UPDATE dbusers SET password = ? WHERE username = ?");
$stmt->bind_param('ss', $newPassword, $username); // 비밀번호와 사용자명 바인딩

// 쿼리 실행 및 결과 처리
if ($stmt->execute()) {
    // 테이블 비밀번호 업데이트 성공 후 MySQL 사용자 비밀번호 변경 쿼리 실행
    $alterUserQuery = "ALTER USER '$username'@'localhost' IDENTIFIED BY '$newPassword'";
    
    if ($conn->query($alterUserQuery) === TRUE) {
        echo json_encode(['message' => '비밀번호가 성공적으로 재설정되었습니다.']);
        
    } else {
        echo json_encode(['message' => 'MySQL 사용자 비밀번호 변경 실패: ' . $conn->error]);
    }
} else {
    echo json_encode(['message' => '비밀번호 재설정 실패: ' . $stmt->error]);
}

// 연결 종료
$stmt->close();
$conn->close();
?>
