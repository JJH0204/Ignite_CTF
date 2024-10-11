
// 테이블 표시 기능
function showTable(tableName) {
    const tableContent = document.getElementById("tableContent");

    let phpFile = '';
    switch (tableName) {
        case 'table1':
            phpFile = 'item.php';
            break;
        case 'table2':
            phpFile = 'user.php';
            break;
        case 'table3':
            phpFile = 'table3.php';
            break;
        default:
            tableContent.textContent = "선택된 테이블이 없습니다.";
            return;
    }

// PHP 파일에서 데이터 가져오기
    fetch(phpFile)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                // 테이블 헤더 생성
                let tableHtml = '<table class="table table-bordered table-striped"><thead><tr>';
                Object.keys(data[0]).forEach(key => {
                    tableHtml += `<th>${key}</th>`;
                });
                tableHtml += '</tr></thead><tbody>';

                // 각 행 데이터를 테이블에 추가
                data.forEach(item => {
                    tableHtml += '<tr>';
                    Object.values(item).forEach(value => {
                        tableHtml += `<td>${value}</td>`;
                    });
                    tableHtml += '</tr>';
                });

                tableHtml += '</tbody></table>';
                tableContent.innerHTML = tableHtml;  // HTML에 테이블 출력
            } else {
                tableContent.textContent = "데이터가 없습니다.";
            }
        })
        .catch(error => console.error('데이터를 불러오는 중 오류 발생:', error));
}