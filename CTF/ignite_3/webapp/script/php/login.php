<?php
header('Content-Type: application/json');

// 데이터베이스 연결 설정
$servername = '127.0.0.1'; // MySQL 서버 주소
$usernameDB = "root"; // DB 사용자 이름
$passwordDB = "1515"; // DB 비밀번호
$dbname = "adminDB"; // 사용할 데이터베이스 이름

// MySQL 연결
$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

// 연결 체크
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => '데이터베이스 연결 실패: ' . $conn->connect_error]));
}

$username = $_POST['username']; // username을 POST로부터 가져옵니다.
$password = $_POST['password']; // password를 POST로부터 가져옵니다.

// SQL 쿼리 작성 (username과 password가 일치하는지 확인)
$sql = "SELECT * FROM adminDB.users WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password); // 사용자 입력을 안전하게 바인딩
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // 인증 성공
    session_start(); // 세션 시작
    $_SESSION['username'] = $username; // 세션에 사용자 이름 저장
    
    echo json_encode(['success' => true, 'username' => $username]);
} else {
    // 인증 실패
    echo json_encode(['success' => false]);
}

// MySQL 연결 종료
$stmt->close();
$conn->close();
?>
