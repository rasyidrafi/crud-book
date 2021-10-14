<?php
use \Psr\Http\Message\ServerRequestInterface as Req;
use \Psr\Http\Message\ResponseInterface as Res;

class PrintRoutes
{
    function post(Req $req, Res $res, array $args)
    {
        include("function/conn.php");
        include("function/useful.php");

        $body = $req->getParsedBody();
        $jsonData = $body["jsonData"];
        $jsonData = json_decode($jsonData);

        $dataBuku = $jsonData[0];
        $uangBayar = $jsonData[1];

        $totalHarga = 0;
        $tglTransaksi = $dataBuku[count($dataBuku) - 1]->created_at;
        foreach ($dataBuku as $buku) {
            $hargaBuku = $buku->total;
            $totalHarga = $totalHarga + (int)$hargaBuku;
        };
        $uangKembali = $uangBayar - $totalHarga;

        $dataRes = [
            "dataBuku" => $dataBuku, 
            "uangBayar" => $uangBayar,
            "totalHarga" => $totalHarga,
            "uangKembali" => $uangKembali,
            "tglTransaksi" => $tglTransaksi
        ];

        return $dataRes;
    }
}
