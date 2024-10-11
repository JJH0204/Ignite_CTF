<?php
// 데이터베이스 연결 정보 설정
$host = '127.0.0.1';
$db = 'GameDB';
$user = 'root';
$pass = '1515';
$charset = 'utf8mb4';

// PDO를 사용하여 데이터베이스 연결 설정
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// 데이터베이스에서 item 테이블의 데이터 조회
$stmt = $pdo->query('SELECT fdItemNum,fdGameMoney,fdItemName FROM item');
$item = $stmt->fetchAll();  // 모든 데이터 가져오기

// JSON 형식으로 결과 반환
header('Content-Type: application/json');
echo json_encode($item);
?>