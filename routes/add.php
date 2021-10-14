<?php
use \Psr\Http\Message\ServerRequestInterface as Req;
use \Psr\Http\Message\ResponseInterface as Res;

class AddRoutes
{
    function post(Req $req, Res $res, array $args)
    {
        include("function/conn.php");

        $body = $req->getParsedBody();
        $dataBuku = $body["dataBuku"];
        $namaPembeli = $body["namaPembeli"];
        $uangBayar = $body["uangBayar"];

        // insert transaksi
        $insertTrans = [
            "nama_pembeli" => $namaPembeli,
            "uang_bayar" => $uangBayar
        ];

        $db->insert("transaksi", $insertTrans);
        $getLast = $db->find("SELECT LAST_INSERT_ID() AS id FROM transaksi");

        $arrayLast = (array)$getLast;
        $idTransaksi = $arrayLast["id"];

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
        }

        return print_r("Success");
    }
}
