$("#book-table").DataTable();

var renderModal = (json) => {
    var parse = JSON.parse(json);
    var dataDetail = parse[0];
    var uangBayar = parse[1];

    console.log(dataDetail);

    $("#id-trns-modal").html(dataDetail[0].id_transaksi);
    var tableTemp = "";
    var totalHold = 0;
    var tglTransaksi = dataDetail[dataDetail.length - 1].created_at;
    dataDetail.forEach(element => {
        totalHold = totalHold + parseInt(element.total);
        tableTemp += `
            <tr>
                <td>${element.book_id}</td>
                <td>${element.nama_buku}</td>
                <td>${element.jumlah}</td>
                <td>${element.disc}</td>
                <td>${formatRupiah(element.harga)}</td>
                <td>${formatRupiah(element.total)}</td>
            </tr>
        `;
    });
    $("#tgl-transaksi").html(tglTransaksi);
    $("#totalHarga").html(`Rp. ${formatRupiah(totalHold)}`);
    $("#totalBayar").html(`Rp. ${formatRupiah(uangBayar)}`);
    $("#totalKembali").html(`Rp. ${formatRupiah(totalHold - uangBayar)}`);
    $("#modal-tbody").html(tableTemp);
    $("#detail-modal").modal("show");
}

var renderDelete = (idDel) => {
    $("#id-del-hold").val(idDel)
    $("#delete-modal").modal("show");
}