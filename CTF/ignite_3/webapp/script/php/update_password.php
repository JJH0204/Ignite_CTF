<?php
header('Content-Type: application/json');

try {
    // JSON 입력 데이터를 파싱
    $input = json_decode(file_get_contents('php://input'), true);
    $username = $input['username'];
    $newPassword = $input['newPassword'];

    // user.json 파일 업데이트
    $jsonFile = '../../json/users.json';
    if (!file_exists($jsonFile)) {
        echo json_encode(['success' => false, 'error' => '파일이 존재하지 않습니다.']);
        exit;
    }

    $jsonData = json_decode(file_get_contents($jsonFile), true);
    if ($jsonData === null) {
        echo json_encode(['success' => false, 'error' => 'JSON 파싱 오류: ' . json_last_error_msg()]);
        exit;
    }

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
        throw new Exception('DB 연결 실패: ' . $conn->connect_error);
    }

    // 비밀번호 업데이트 쿼리 준비
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
    if (!$stmt) {
        throw new Exception('쿼리 준비 실패: ' . $conn->error);
    }

    // 쿼리 바인딩
    $stmt->bind_param('ss', $newPassword, $username);

    // 쿼리 실행 및 결과 확인
    if ($stmt->execute()) {
        echo json_encode(['message' => '비밀번호가 성공적으로 재설정되었습니다.']);
    } else {
        echo json_encode(['error' => '비밀번호 재설정 실패. SQL Error: ' . $stmt->error]); // 쿼리 오류 출력
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
