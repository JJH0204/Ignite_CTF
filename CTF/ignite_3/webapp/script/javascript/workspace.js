// 예제 데이터와 함께 SQL 결과 출력
function executeQuery() {
    const result = [
        { fdNum: 5, fdVirtualItemDescNum: 252, fdSupplyItemDescNum: 240, fdHasExpireTime: "TRUE", fdExpireMinute: 43200, fdCount: 0 },
        { fdNum: 7, fdVirtualItemDescNum: 254, fdSupplyItemDescNum: 243, fdHasExpireTime: "TRUE", fdExpireMinute: 43200, fdCount: 0 },
        { fdNum: 10, fdVirtualItemDescNum: 257, fdSupplyItemDescNum: 244, fdHasExpireTime: "TRUE", fdExpireMinute: 43200, fdCount: 0 },
        { fdNum: 13, fdVirtualItemDescNum: 260, fdSupplyItemDescNum: 245, fdHasExpireTime: "TRUE", fdExpireMinute: 43200, fdCount: 0 },
    ];

    let outputHtml = "<table><tr><th>fdNum</th><th>fdVirtualItemDescNum</th><th>fdSupplyItemDescNum</th><th>fdHasExpireTime</th><th>fdExpireMinute</th><th>fdCount</th></tr>";
    result.forEach(row => {
        outputHtml += `<tr><td>${row.fdNum}</td><td>${row.fdVirtualItemDescNum}</td><td>${row.fdSupplyItemDescNum}</td><td>${row.fdHasExpireTime}</td><td>${row.fdExpireMinute}</td><td>${row.fdCount}</td></tr>`;
    });
    outputHtml += "</table>";

    document.getElementById('sqlOutput').innerHTML = outputHtml;
}