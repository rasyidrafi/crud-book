$("#book-table").DataTable();

var renderModal = (json) => {
    var dataDetail = JSON.parse(json);
    console.log(dataDetail);

    $("#detail-modal").modal("show");
}