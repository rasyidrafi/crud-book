<?php 
    $nama = "Rasyid";
    $noPenjualan = 225;
?>

<!DOCTYPE html>
<html lang="en">
<?php include("layout/_head.php"); ?>

<body>
    <?php include("components/navbar.php") ?>

    <style>
        .form-control-sm {
            margin-bottom: 8px;
        }

        .cb {
            min-height: 156px;
            overflow-y: auto;
        }

        .total-title {
            border-bottom: solid 2px black;
        }
    </style>

    <div class="container py-4">
        <div class="row">
            <div class="col-md-6 mb-2">
                <div class="card">
                    <div class="card-body cb">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-primary">Add New Book Quickly</span>
                            <button onclick="addBook()" type="button" class="btn btn-sm btn-primary">+ Add Book</button>
                        </div>
                        <form id="add-form">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" class="form-control-sm form-control" required placeholder="Book name" name="name">
                                </div>
                                <div class="col-md-4">
                                    <input type="number" class="form-control-sm form-control" required placeholder="Book Id" name="id">
                                </div>
                                <div class="col-md-4">
                                    <input type="number" class="form-control-sm form-control" required placeholder="Quantity" name="qty">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control-sm form-control" id="bookPrice" required placeholder="Price / Item" name="price">
                                </div>
                                <div class="col-md-4">
                                    <input type="number" class="form-control-sm form-control" id="discount" placeholder="Discount %" name="disc">
                                </div>
                            </div>
                            <button type="submit" id="submit-form" class="d-none">
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-2">
                <div class="card">
                    <div class="card-body cb">
                        <h5 class="fw-bold total-title">TOTAL</h5>
                        <h1 class="fw-bold text-danger text-end">Rp. <span id="totalPrice">0</span></h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body overflow-auto">
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
                            <tbody id="tableNya">
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <?php include("layout/_script.php") ?>
    <script src="js/index.js"></script>
</body>

</html>