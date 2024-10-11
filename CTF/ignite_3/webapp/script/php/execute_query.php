<?php
// 데이터베이스 연결 정보 설정
$host = '127.0.0.1'; // 데이터베이스 서버 주소
$db = 'GameDB'; // 사용할 데이터베이스 이름
$user = 'root'; // 데이터베이스 사용자명
$pass = '1515'; // 데이터베이스 비밀번호
$charset = 'utf8mb4'; // 문자 인코딩 설정 (UTF-8 사용)

// PDO를 사용하여 데이터베이스 연결 설정
$dsn = "mysql:host=$host;dbname=$db;charset=$charset"; // DSN 문자열 생성
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // 오류 발생 시 예외를 발생시키도록 설정
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // 연관 배열로 데이터를 반환하도록 설정
    PDO::ATTR_EMULATE_PREPARES   => false, // 실제 프리페어드 스테이트먼트를 사용하도록 설정
];

try {
    // PDO 객체를 생성하여 데이터베이스 연결을 시도
    $pdo = new PDO($dsn, $user, $pass, $options);

    // JSON 형태로 POST 요청의 데이터를 가져옴
    $data = json_decode(file_get_contents('php://input'), true); // JSON 형식으로 변환하여 $data 변수에 저장
    $query = $data['query']; // 클라이언트로부터 받은 SQL 쿼리를 변수에 저장

    // SQL 쿼리 실행
    if (stripos($query, 'select') === 0) { // 쿼리가 'SELECT'로 시작하는지 확인
        // SELECT 쿼리인 경우 실행
        $stmt = $pdo->query($query); // 쿼리를 실행하고 결과를 가져옴
        $items = $stmt->fetchAll(); // 결과의 모든 행을 연관 배열로 가져옴
        header('Content-Type: application/json'); // 응답의 Content-Type을 JSON으로 설정
        echo json_encode($items); // 결과 데이터를 JSON 형식으로 인코딩하여 출력
    } else {
        // INSERT, UPDATE, DELETE 쿼리인 경우
        $stmt = $pdo->prepare($query); // 쿼리를 준비
        $stmt->execute(); // 준비된 쿼리를 실행
        // 성공적으로 실행된 후의 응답을 JSON으로 반환
        header('Content-Type: application/json'); // 응답의 Content-Type을 JSON으로 설정
        echo json_encode(['message' => 'Query executed successfully.']); // 성공 메시지 반환
    }
} catch (\PDOException $e) {
    // 오류 발생 시 JSON 형식으로 오류 메시지를 반환
    header('Content-Type: application/json'); // 응답의 Content-Type을 JSON으로 설정
    echo json_encode(['error' => $e->getMessage()]); // 예외의 오류 메시지를 JSON으로 인코딩하여 출력
}
?>
