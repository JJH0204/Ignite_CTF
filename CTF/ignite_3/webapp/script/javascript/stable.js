// fetch 및 showTable 관련 JavaScript 코드 (변경 없음)
// IP 주소 가져오기 및 표시
// fetch('https://api.ipify.org?format=json')
//     .then(response => response.json())
//     .then(data => {
//         document.getElementById("user-ip").textContent = data.ip;
//     })
//     .catch(() => {
//         // 실패 시 WebRTC 방식을 이용하여 IP 주소 가져오기
//         let ipFound = false;
//         const rtc = new RTCPeerConnection();
//         rtc.createDataChannel('');
//         rtc.createOffer().then(offer => rtc.setLocalDescription(offer));
//         rtc.onicecandidate = function (event) {
//             if (!event || !event.candidate || !event.candidate.candidate || ipFound) return;
//             const candidate = event.candidate.candidate;
//             const ipMatch = candidate.match(/\b\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\b/);
//             if (ipMatch) {
//                 document.getElementById("user-ip").textContent = ipMatch[0];
//                 ipFound = true;
//             }
//         };
//         // 실패 시 예외 처리
//         setTimeout(() => {
//             if (!ipFound) document.getElementById("user-ip").textContent = "IP 가져오기 실패";
//         }, 2000);
//     });

fetch('../script/php/get_ip.php')
    .then(response => response.json()) // 응답 데이터를 JSON 형식으로 변환
    .then(data => {
        // IP 주소를 'user-ip' ID를 가진 요소에 표시
        document.getElementById('user-ip').textContent = data.ip;
    })
    .catch(error => {
        // IP를 가져오는 도중 에러 발생 시 콘솔에 에러 메시지 출력
        console.error('Error fetching IP:', error);
        // 'user-ip' ID를 가진 요소에 'IP 가져오기 실패' 메시지 표시
        document.getElementById('user-ip').textContent = 'IP 가져오기 실패';
    });

// 사이드바 토글 기능 구현
const toggleSidebarBtn = document.getElementById('toggleSidebarBtn'); // 사이드바 토글 버튼 요소
const sidebar = document.getElementById('sidebar'); // 사이드바 요소
const mainContent = document.getElementById('mainContent'); // 메인 콘텐츠 요소

// 토글 버튼 클릭 이벤트 리스너 추가
toggleSidebarBtn.addEventListener('click', function () {
    // 사이드바가 숨겨져 있는지 확인
    if (sidebar.style.left === "-200px") {
        // 숨겨져 있다면 사이드바를 보이게 설정
        sidebar.style.left = "0";
        mainContent.classList.add('active'); // mainContent에 'active' 클래스 추가
    } else {
        // 보이는 상태라면 사이드바를 숨김
        sidebar.style.left = "-200px";
        mainContent.classList.remove('active'); // mainContent에서 'active' 클래스 제거
    }
});

// 로그아웃 버튼 클릭 시 로그인 페이지로 이동
const logoutBtn = document.getElementById('logoutBtn'); // 로그아웃 버튼 요소
logoutBtn.addEventListener('click', function () {
    // 클릭 시 로그인 페이지로 이동
    window.location.href = 'login.html';
});
