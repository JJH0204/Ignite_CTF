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
    .then(response => response.json())
    .then(data => {
        document.getElementById('user-ip').textContent = data.ip;
    })
    .catch(error => {
        console.error('Error fetching IP:', error);
        document.getElementById('user-ip').textContent = 'IP 가져오기 실패';
    });


// 사이드바 토글 기능 구현
const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');

toggleSidebarBtn.addEventListener('click', function () {
    if (sidebar.style.left === "-200px") {
        sidebar.style.left = "0";
        mainContent.classList.add('active');
    } else {
        sidebar.style.left = "-200px";
        mainContent.classList.remove('active');
    }
});

// 로그아웃 버튼 클릭 시 로그인 페이지로 이동
const logoutBtn = document.getElementById('logoutBtn');
logoutBtn.addEventListener('click', function () {
    window.location.href = 'login.html'; // 로그인 페이지로 이동
});
