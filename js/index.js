var dataBuku = [];

$("#bookPrice").on('input propertychange', function() {
    var val = $(this).val();
    $(this).val(formatRupiah(val, "Rp. "))
});

$("#book-table").DataTable();

var countTotal = () => {
    let totalTemp = 0;
    dataBuku.forEach(data => {
        var price = (data[2] * data[3]) - percentage((data[2] * data[3]), parseInt(data[4]));
        totalTemp = totalTemp + price;
    });
    return totalTemp;
}

var addBook = () => {
    var price = $("#bookPrice").val()
    if (price) {
        price = price.replace("Rp. ", "");
        price = price.replace(/\./g, "");
        price = parseInt(price);
        $("#bookPrice").val(price);
    }
    $("#submit-form").click();
}

$("#add-form").submit(function(e){
    e.preventDefault();
    var bookData = $(this).serializeArray();
    var bookName = bookData[0].value;
    var bookId = bookData[1].value;
    var bookQty = bookData[2].value;
    var bookPrice = bookData[3].value;
    var bookDisc = bookData[4].value;
    dataBuku.push([bookName, bookId, bookQty, bookPrice, bookDisc]);
    $(this).trigger("reset");

    $("#totalPrice").html(formatRupiah(`${countTotal()}`));

    var isiTabel = "";
    dataBuku.forEach((data, i) => {
        isiTabel += `
            <tr>
                <td>${i + 1}</td>
                <td>${data[1]}</td>
                <td>${data[0]}</td>
                <td>${data[2]}</td>
                <td>${data[3]}</td>
                <td>${data[4]}</td>
                <td>${(data[2] * data[3]) - percentage((data[2] * data[3]), parseInt(data[4]))}</td>
                <td>
                <div class="btn-group" role="group">
                    <button type="button" onclick="del(${i})" class="btn btn-sm btn-danger">Del</button>
                </div>
                </td>
            </tr>
        `;
    });
    $("#tableNya").html(isiTabel);
    $("#book-table").DataTable();
})

var del = (index) => {
    dataBuku.splice(index, 1);
    $("#totalPrice").html(formatRupiah(`${countTotal()}`));

    var isiTabel = "";
    dataBuku.forEach((data, i) => {
        isiTabel += `
            <tr>
                <td>${i + 1}</td>
                <td>${data[1]}</td>
                <td>${data[0]}</td>
                <td>${data[2]}</td>
                <td>${data[3]}</td>
                <td>${data[4]}</td>
                <td>${(data[2] * data[3]) - percentage((data[2] * data[3]), parseInt(data[4]))}</td>
                <td>
                <div class="btn-group" role="group">
                    <button type="button" onclick="del(${i})" class="btn btn-sm btn-danger">Del</button>
                </div>
                </td>
            </tr>
        `;
    });
    $("#tableNya").html(isiTabel);
    $("#book-table").DataTable();
}

