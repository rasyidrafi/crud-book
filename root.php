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
                        <table class="table table-bordered table-hover table-sm" id="book-table">
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
                                            <button onclick='renderModal(`<?php echo json_encode($userData["dataBuku"]) ?>`)' class="btn btn-sm btn-success">Detail</button>
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

    <div id="detail-modal" class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-detail-title">Detail Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <?php include("layout/_script.php") ?>
    <script src="js/root.js"></script>
</body>

</html>