<?php 
    require "db/conn.php";
    
    $dataBuku = $_POST["dataBuku"];
    $namaPembeli = $_POST["namaPembeli"];

    // insert transaksi
    $insertTrans = [
        "nama_pembeli" => $namaPembeli
    ];
    $db->insert("transaksi", $insertTrans);
    $getTransaksi = $db->select()->from("transaksi")->limit(1)->orderBy("created_at DESC")->find();
    $getTransaksi = (array)$getTransaksi;

    // Get Id Transaksi
    $idTransaksi = $getTransaksi["id"];

    foreach ($dataBuku as $buku) {
        $judul = $buku[0];
        $idBuku = (int)$buku[1];
        $qty = (int)$buku[2];
        $price = (int)$buku[3];
        $disc = (int)$buku[4];
        $totalTemp = ($qty * $price);
        $totalReal = $totalTemp - (($totalTemp / 100) * $disc);
     
        $insertData = [
            "id_transaksi" => $idTransaksi,
            "book_id" => $idBuku,
            "nama_buku" => $judul,
            "jumlah" => $qty,
            "harga" => $price,
            "disc" => $disc,
            "total" => $totalReal
        ];
        $db->insert("detail_transaksi", $insertData);

        return "SUCCESS";
    }

?>