$(document).ready(function () {
    $('#formFile').off('change').on('change', onChangeCheckFileExtension);
    $('#loadFile').off('click').on('click', onClickSaveFileContent);
});

onChangeCheckFileExtension = function () {
    let fileInput = document.getElementById('formFile');
    let fileName = fileInput.value;
    let fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
    if (fileExtension === 'csv') {
        document.getElementById('loadFile').disabled = false;
    }
}

onClickSaveFileContent = function (e) {
    let fileInput = document.getElementById('formFile');
    let file = fileInput.files[0];
    let fileContent;
    let reader = new FileReader();
    reader.onload = function (e) {
        fileContent = e.target.result;
        $.ajax({
            url: '../../index.php/TransactionController/InsertTransaction',
            type: "POST",
            success: onPostInsertTransaction,
            async: true,
            context: this,
            crossBrowser: "true",
            data: { 'fileContent': fileContent }
        });
    };
    reader.readAsText(file);

}

onPostInsertTransaction = function (response) {
    response = $.parseJSON(response);
    let tableTransactions = document.getElementById('transactions');
    _createTableOfElements(response, tableTransactions);
}

_createTableOfElements = function (response, table) {
    _destroyTableOfElements(table);
    if (!table.hasChildNodes()) {
        let tbody = document.createElement('tbody');
        
        for (let i = 0; i < response.dat.length; i++) {
            let row = document.createElement('tr');
            let fields = response.dat[i];
            fields = fields.split(',');
            fields.forEach(field => {
                let column = document.createElement("td");
                let textNode = document.createTextNode(field + ' ');
                column.appendChild(textNode);
                row.appendChild(column);
            });
            
            tbody.appendChild(row);
        }
        let closeButton = document.createElement('button');
        closeButton.className = 'btn-close';
        closeButton.setAttribute('aria-label', 'Close');
        closeButton.onclick = function () {
            _destroyTableOfElements(table);
        };
        table.appendChild(closeButton);
        table.appendChild(tbody);

        let totalIncome = document.createElement('p');
        totalIncome.innerText = 'TOTAL Income: ' + response.income;
        let totalExpense = document.createElement('p');
        totalExpense.innerText = 'TOTAL Expense: ' + response.expense;
        let totalNet = document.createElement('p');
        totalNet.innerText = 'NET Total: ' + parseFloat((response.income - response.expense).toFixed(2));

        table.appendChild(totalIncome);
        table.appendChild(totalExpense);
        table.appendChild(totalNet);
        document.body.appendChild(table);

    }
}

_destroyTableOfElements = function (table) {
    while (table.firstChild) {
        table.removeChild(table.firstChild);
    }
}
