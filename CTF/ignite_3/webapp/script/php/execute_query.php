<?php
session_start();
// UTF-8 인코딩을 명시적으로 설정
header('Content-Type: text/html; charset=utf-8');

// 데이터베이스 연결 설정
$host = '127.0.0.1'; // DB 호스트 주소를 설정. 여기서는 로컬 서버 주소인 127.0.0.1을 사용
$dbname = 'GameDB'; // 사용할 데이터베이스의 이름을 설정 (GameDB)
$user = isset($_SESSION['username']) ? $_SESSION['username'] : ''; // 데이터베이스 사용자명
$password = isset($_SESSION['password']) ? $_SESSION['password'] : ''; // 데이터베이스 비밀번호

// MariaDB 연결
$conn = new mysqli($host, $user, $password, $dbname);

// 연결 상태 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 인코딩 설정
$conn->set_charset("utf8"); // MariaDB 연결에 UTF-8 설정을 추가

// 클라이언트에서 SQL 쿼리를 받아옴
$sql_query = $_POST['sql'];

// SQL 쿼리 실행
$result = $conn->query($sql_query);

// 실행 결과 확인
if ($result) {
    if ($result->num_rows > 0) {
        // 결과를 JSON 형식으로 반환
        $rows = array();
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode($rows, JSON_UNESCAPED_UNICODE); // 결과 배열을 JSON 형식으로 변환하여 클라이언트에 반환 (한글 깨짐 방지)
    } else {
        echo json_encode(["message" => "결과가 없습니다."], JSON_UNESCAPED_UNICODE); // 결과가 없는 경우 메시지를 JSON 형식으로 반환 (한글 깨짐 방지)
    }
} else {
    echo json_encode(["error" => "쿼리 실행 오류: " . $conn->error], JSON_UNESCAPED_UNICODE); // 쿼리 실행에 실패한 경우 오류 메시지를 JSON 형식으로 반환 (한글 깨짐 방지)
}

// 연결 종료
$conn->close();
?>
