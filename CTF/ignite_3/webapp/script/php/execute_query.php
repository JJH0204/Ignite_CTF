<?php
// 데이터베이스 연결 설정
$host = '127.0.0.1'; // DB 호스트 주소를 설정. 여기서는 로컬 서버 주소인 127.0.0.1을 사용
$dbname = 'GameDB'; // 사용할 데이터베이스의 이름을 설정 (GameDB)
$user = 'root'; // 데이터베이스 사용자명 (root)
$password = '1515'; // 데이터베이스 사용자 비밀번호 (1515)

// MariaDB 연결
$conn = new mysqli($host, $user, $password, $dbname); // mysqli 객체를 사용하여 데이터베이스에 연결

// 연결 상태 확인
if ($conn->connect_error) { // 연결이 실패했는지 확인
    die("Connection failed: " . $conn->connect_error); // 연결에 실패하면 오류 메시지를 출력하고 스크립트를 종료
}

// 클라이언트에서 SQL 쿼리를 받아옴
$sql_query = $_POST['sql']; // POST 요청으로 전달된 'sql' 데이터를 가져와 변수에 저장

// SQL 쿼리 실행
$result = $conn->query($sql_query); // 사용자가 입력한 SQL 쿼리를 실행하고 결과를 $result에 저장

// 실행 결과 확인
if ($result) { // 쿼리 실행이 성공했는지 확인
    if ($result->num_rows > 0) { // 쿼리 실행 결과에 데이터 행이 있는지 확인
        // 결과를 JSON 형식으로 반환
        $rows = array(); // 결과 데이터를 저장할 빈 배열 선언
        while($row = $result->fetch_assoc()) { // 결과를 하나씩 가져와 연관 배열로 변환
            $rows[] = $row; // 변환된 결과를 $rows 배열에 추가
        }
        echo json_encode($rows, JSON_UNESCAPED_UNICODE); // 결과 배열을 JSON 형식으로 변환하여 클라이언트에 반환
    } else {
        echo json_encode(["message" => "결과가 없습니다."]); // 결과가 없는 경우 메시지를 JSON 형식으로 반환
    }
} else {
    echo json_encode(["error" => "쿼리 실행 오류: " . $conn->error]); // 쿼리 실행에 실패한 경우 오류 메시지를 JSON 형식으로 반환
}

// 연결 종료
$conn->close(); // 데이터베이스 연결을 종료
?>
