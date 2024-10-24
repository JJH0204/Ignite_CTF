<?php
// 사용자의 IP 주소 가져오기
$user_ip = $_SERVER['REMOTE_ADDR']; // 'REMOTE_ADDR' 서버 변수를 사용해 사용자의 IP 주소를 $user_ip 변수에 저장

// IP 주소를 반환하기 위해서 간단히 JSON으로 출력
echo json_encode(['ip' => htmlspecialchars($user_ip)]); // XSS 공격 방지를 위해 IP 주소를 HTML로 인코딩하고, JSON 형식으로 응답
?>
