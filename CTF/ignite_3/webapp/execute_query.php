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

    // JSON 형태로 POST 요청의 데이터를 가져옴
    $data = json_decode(file_get_contents('php://input'), true);
    $query = $data['query']; // SQL 쿼리 가져오기

    // SQL 쿼리 실행
    if (stripos($query, 'select') === 0) {
        // SELECT 쿼리인 경우
        $stmt = $pdo->query($query);
        $items = $stmt->fetchAll();  // 모든 데이터 가져오기
        header('Content-Type: application/json');
        echo json_encode($items);
    } else {
        // INSERT, UPDATE, DELETE 쿼리인 경우
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        // 성공적으로 실행된 후의 응답
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Query executed successfully.']);
    }
} catch (\PDOException $e) {
    // 오류 메시지를 JSON 형식으로 반환
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?>

