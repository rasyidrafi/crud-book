$("#bookPrice").on('input propertychange', function() {
    var val = $(this).val();
    $(this).val(formatRupiah(val, "Rp. "))
});

$("#book-table").DataTable();

var addBook = () => {
    var price = $("#bookPrice").val().replace("Rp. ", "");
    price = price.replace(/\./g, "");
    console.log(price)
    price = parseInt(price);
    $("#bookPrice").val(price);
    $("#submit-form").click();
}