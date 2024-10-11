<?php
// 데이터베이스 연결 정보 설정
$host = '127.0.0.1'; // 데이터베이스 서버 주소
$db = 'GameDB'; // 사용할 데이터베이스 이름
$user = 'root'; // 데이터베이스 사용자명
$pass = '1515'; // 데이터베이스 비밀번호
$charset = 'utf8mb4'; // 문자 인코딩 설정 (UTF-8을 사용하여 다양한 문자 지원)

// PDO를 사용하여 데이터베이스 연결 설정
$dsn = "mysql:host=$host;dbname=$db;charset=$charset"; // DSN(Data Source Name) 문자열 생성
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // 오류 발생 시 예외를 던지도록 설정
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // 데이터를 연관 배열로 반환하도록 설정
    PDO::ATTR_EMULATE_PREPARES   => false, // 실제 프리페어드 스테이트먼트를 사용하도록 설정
];

try {
    // PDO 객체를 생성하여 데이터베이스 연결 시도
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // 연결 오류가 발생하면 예외를 던짐
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// 데이터베이스에서 item 테이블의 데이터 조회
$stmt = $pdo->query('SELECT fdItemNum, fdGameMoney, fdItemName FROM item'); // 'item' 테이블에서 데이터 조회하는 쿼리 실행
$item = $stmt->fetchAll();  // 모든 데이터 행을 가져와 $item 변수에 저장 (연관 배열 형태)

// JSON 형식으로 결과 반환
header('Content-Type: application/json'); // 응답의 Content-Type을 JSON 형식으로 설정
echo json_encode($item); // 조회된 데이터를 JSON으로 변환하여 출력
?>
