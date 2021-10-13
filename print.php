<?php
$dataPrint = json_decode($_POST['jsonData']);
$dataBuku = $dataPrint[0];
$uangBayar = $dataPrint[1];

function rupiah($angka){
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include("layout/_head.php"); ?>

<body class="p-4">
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
            <tbody>
                <?php 
                    $i = 0 ;
                    $totalHold = 0;
                    $tglTransaksi = $dataBuku[count($dataBuku) - 1]->created_at;
                    foreach ($dataBuku as $buku): ?>
                    <tr>
                        <td>
                            <?php 
                                $hargaBuku = $buku->total;
                                $totalHold = $totalHold + (int)$hargaBuku;
                                echo $buku->id;
                            ?>
                        </td>
                        <td><?= $buku->nama_buku ?></td>
                        <td><?= $buku->jumlah ?></td>
                        <td><?= $buku->disc ?></td>
                        <td><?= rupiah($buku->harga) ?></td>
                        <td><?= $buku->total ?></td>
                    </tr>
                        <!-- $buku = (array)$buku; -->
                        <!-- $totalHold = $totalHold + (int)$buku['total']; -->
                        
                    <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h5>Total Harga : <span class="text-danger fw-bold"><?= rupiah($totalHold) ?></span></h5>
        </div>
        <div class="col-md-6 text-end">
            <h5>Total Bayar : <span class="text-danger fw-bold"><?= rupiah($dataPrint[1]); ?></span></h5>
        </div>
        <div class="text-end">
            <h5>Kembalian : <span class="fw-bold"><?= rupiah($uangBayar - $totalHold) ?></span></h5>
        </div>
    </div>
    <span>Transaksi dilakukan pada : <span class="fw-bold"><?= $tglTransaksi; ?></span></span>

    <?php include("layout/_script.php"); ?>
    
    <script src="/js/print.js"></script>
</body>

</html>