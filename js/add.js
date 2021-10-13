var dataBuku = [];

$("#bookPrice").on('input propertychange', function () {
    var val = $(this).val();
    $(this).val(formatRupiah(val, "Rp. "))
});

$("#ygDibayar").on("input propertyChange", function () {
    var val = $(this).val();
    $(this).val(formatRupiah(val, "Rp. "));
    var totalHarga = $("#totalPrice").text();
    totalHarga = totalHarga.replace("Rp. ", "");
    totalHarga = totalHarga.replace(/\./g, "");
    totalHarga = parseInt(totalHarga);

    var uangBayar = $(this).val();
    uangBayar = uangBayar.replace("Rp. ", "");
    uangBayar = uangBayar.replace(/\./g, "");
    uangBayar = parseInt(uangBayar);

    if (uangBayar > totalHarga) {
        var kembalian = totalHarga - uangBayar;
        $("#totalKembali").html(formatRupiah(kembalian));
    } else $("#totalKembali").html(formatRupiah(0));
})

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

var formatTable = () => {
    $("#totalPrice").html(formatRupiah(`${countTotal()}`));

    $("#table-container").empty();
    $("#table-container").html(`
    <table class="table table-bordered table-hover table-sm" id="book-table">
        <thead>
            <tr class="text-primary" style="text-transform: uppercase;">
                <th>No</th>
                <th>Id</th>
                <th>Name</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Disc %</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tableNya"></tbody>
    </table>`);

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

$("#add-form").submit(function (e) {
    e.preventDefault();
    var bookData = $(this).serializeArray();
    var bookName = bookData[0].value;
    var bookId = bookData[1].value;
    var bookQty = bookData[2].value;
    var bookPrice = bookData[3].value;
    var bookDisc = bookData[4].value;
    dataBuku.push([bookName, bookId, bookQty, bookPrice, bookDisc]);
    $(this).trigger("reset");

    formatTable();
})

var del = (index) => {
    dataBuku.splice(index, 1);
    formatTable();
}

$("#form-oke").submit(function (e) {
    e.preventDefault();
    var namaPembeli = $("#namaPembeli").val();
    var uangBayar = $("#ygDibayar").val();
    uangBayar = uangBayar.replace("Rp. ", "");
    uangBayar = uangBayar.replace(/\./g, "");
    uangBayar = parseInt(uangBayar);
    $.post({
        url: "/add",
        type: "POST",
        data: {
            dataBuku,
            namaPembeli,
            uangBayar
        },
        success: data => {
            setTimeout(() => window.location.href = "/", 1000);
        }
    })
})

