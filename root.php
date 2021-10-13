<?php
require "db/conn.php";
$userDataTemp = [];
$getuser = $db->select()->from("transaksi")->findAll();
foreach ($getuser as $user) {
    $user = (array)$user;
    $totalBuku = 0;
    $totalHarga = 0;
    $detailData = $db->select()->from("detail_transaksi")->where("id_transaksi", "=", $user["id"])->findAll();
    $dataBuku = [];
    foreach ($detailData as $detail) {
        $detail = (array)$detail;
        $totalHarga = $totalHarga + $detail["total"];
        $totalBuku = $totalBuku + $detail["jumlah"];
        array_push($dataBuku, $detail);
    }

    array_push($userDataTemp, [
        "id" => $user["id"],
        "nama_pembeli" => $user["nama_pembeli"],
        "created_at" => $user["created_at"],
        "uang_bayar" => $user["uang_bayar"],
        "totalBuku" => $totalBuku,
        "totalHarga" => $totalHarga,
        "dataBuku" => $dataBuku
    ]);
}

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
        <div class="card">
            <div class="card-body cb">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold text-primary">Data Pembeli</span>
                    <a href="/add" class="btn btn-sm btn-primary">+ Tambah Data</a>
                </div>

                <div class="card border-0">
                    <div class="card-body overflow-auto">
                        <table class="pt-2 table-striped table table-bordered table-hover table-sm" id="book-table">
                            <thead>
                                <tr class="text-primary" style="text-transform: uppercase;">
                                    <th>No</th>
                                    <th>Id</th>
                                    <th>Nama Pembeli</th>
                                    <th>Total Buku</th>
                                    <th>Total Harga</th>
                                    <th>Waktu</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < count($userDataTemp); $i++) : ?>
                                    <?php $userData = (array)$userDataTemp[$i]; ?>
                                    <tr>
                                        <td><?php echo $i + 1; ?></td>
                                        <td><?php echo $userData["id"]; ?></td>
                                        <td><?php echo $userData["nama_pembeli"]; ?></td>
                                        <td><?php echo $userData["totalBuku"]; ?></td>
                                        <td><?php echo $userData["totalHarga"]; ?></td>
                                        <td><?php echo $userData["created_at"]; ?></td>
                                        <td>
                                            <div class="btn-group btn-group-sm"></div>
                                            <button onclick='renderModal(`<?php echo json_encode([$userData["dataBuku"], $userData["uang_bayar"]]) ?>`)' class="btn btn-sm btn-success">Detail</button>
                                            <button onclick='renderDelete(`<?php echo $userData["id"]; ?>`)' class="btn-sm btn-danger btn">Delete</button>
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="detail-modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-detail-title">Transaksi NOTA-<span id="id-trns-modal">0</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 class="fw-bold text-center">Lamda Book Store</h4>
                    <span class="text-center d-block px-4">Perumahan Griya Shanta Permata, N-524, Mojolangu, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141</span>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID Buku</th>
                                    <th>Nama Buku</th>
                                    <th>Jumlah</th>
                                    <th>Diskon</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="modal-tbody"></tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Total Harga : <span class="text-danger fw-bold" id="totalHarga">Rp. 0</span></h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <h5>Total Bayar : <span class="text-danger fw-bold" id="totalBayar">Rp. 0</span></h5>
                        </div>
                        <div class="text-end">
                            <h5>Kembalian : <span class="fw-bold" id="totalKembali">Rp. 0</span></h5>
                        </div>
                    </div>
                    <span>Transaksi dilakukan pada : <span class="fw-bold" id="tgl-transaksi"></span></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Print Nota</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <h2 class="text-danger fw-bold">Warning!</h2>
                    <span class="d-block px-2 text-secondaary">Aksi ini akan menghapus data dalam database, aksi ini tidak dapat diurungkan</span>
                    <br>
                    <span>ID Transaksi : </span>
                    <input type="text" readonly id="id-del-hold" class="text-center form-control mt-2">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger">Confirm</button>
                </div>
            </div>
        </div>
    </div>


    <?php include("layout/_script.php") ?>
    <script src="js/root.js"></script>
</body>

</html>