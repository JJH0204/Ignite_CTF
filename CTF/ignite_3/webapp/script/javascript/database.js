function showTable(tableName) {
    // 'tableContent'라는 ID를 가진 요소를 선택해서 테이블이 출력될 위치를 지정
    const tableContent = document.getElementById("tableContent");

    // 사용할 PHP 파일명을 담을 변수 초기화
    let phpFile = '';
    switch (tableName) {
        case 'table1':
            // table1 선택 시 호출할 PHP 파일 지정
            phpFile = '/script/php/get_itemDB.php';
            break;
        case 'table2':
            // table2 선택 시 호출할 PHP 파일 지정
            phpFile = '/script/php/get_userDB.php';
            break;
        case 'table3':
            // table3 선택 시 호출할 PHP 파일 지정
            phpFile = '/script/php/table3.php';
            break;
        default:
            // 아무 테이블도 선택되지 않은 경우 안내 메시지 표시하고 함수 종료
            tableContent.textContent = "선택된 테이블이 없습니다.";
            return; // 함수 종료, 더 이상 코드 실행하지 않음
    }

    const username = sessionStorage.getItem('username');
    const phpFileWithParam = `${phpFile}?username=${encodeURIComponent(username)}`;  

    // PHP 파일로부터 데이터 가져오기
    fetch(phpFileWithParam, {
        method: 'GET',
        headers : {
            'X-Username': username, // 요청 헤더에 사용자 이름 추가
        }
    })
    .then(response => response.json()) // 서버 응답을 JSON 형식으로 변환
    .then(data => {
        // 데이터가 있으면 테이블 생성 시작
        if (data.length > 0) {
            // 테이블 태그와 헤더 생성
            let tableHtml = '<table class="table table-bordered table-striped"><thead><tr>';
            // 첫 번째 객체의 키를 사용하여 테이블 헤더 추가
            Object.keys(data[0]).forEach(key => {
                tableHtml += `<th>${key}</th>`; // 각 키를 테이블 헤더로 추가
            });
            tableHtml += '</tr></thead><tbody>'; // 헤더 행 닫고 본문 시작

            // 데이터 행 추가
            data.forEach(item => {
                tableHtml += '<tr>'; // 새로운 행 시작
                // 각 객체의 값을 가져와서 테이블 데이터 셀로 추가
                Object.values(item).forEach(value => {
                    tableHtml += `<td>${value}</td>`; // 셀 추가
                });
                tableHtml += '</tr>'; // 행 닫기
            });

            // 테이블 닫기 태그 추가하고 HTML에 삽입
            tableHtml += '</tbody></table>'; // 테이블 종료
            tableContent.innerHTML = tableHtml; // tableContent 요소에 HTML 코드 삽입하여 테이블 표시
        } else {
            // 데이터가 없으면 안내 메시지 표시
            tableContent.textContent = "데이터가 없습니다.";
        }
    })
    .catch(error => {
        // 데이터 가져오는 중 오류가 발생한 경우
        console.error('데이터를 불러오는 중 오류 발생:', error); // 오류 내용을 콘솔에 출력
    });
}
