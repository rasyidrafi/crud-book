<?php

use \Psr\Http\Message\ServerRequestInterface as Req;
use \Psr\Http\Message\ResponseInterface as Res;

class IndexRoutes
{
    function get()
    {
        include("function/conn.php");
        include("function/useful.php");

        $getuser = $db->findAll("SELECT * FROM transaksi");
        $userDataTemp = [];
        $totalBukuTerjual = 0;
        $totalUangTerima = 0;
        foreach ($getuser as $user) {
            $totalBuku = 0;
            $totalHarga = 0;
            $detailData = $db->select()
                ->from("detail_transaksi")
                ->where("id_transaksi", "=", $user->id)
                ->findAll();

            $dataBuku = [];
            foreach ($detailData as $detail) {
                $totalHarga = $totalHarga + $detail->total;
                $totalBuku = $totalBuku + $detail->jumlah;
                array_push($dataBuku, $detail);
            }
        
            array_push($userDataTemp, [
                "id" => $user->id,
                "nama_pembeli" => $user->nama_pembeli,
                "created_at" => $user->created_at,
                "uang_bayar" => $user->uang_bayar,
                "totalBuku" => $totalBuku,
                "totalHarga" => $totalHarga,
                "dataBuku" => $dataBuku
            ]);

            $totalBukuTerjual = $totalBukuTerjual + $totalBuku;
            $totalUangTerima = $totalUangTerima + $totalHarga;
        }

        $dataRes = [
            "transaksiData" => $userDataTemp, 
            "totalBukuTerjual" => $totalBukuTerjual,
            "totalUang" => $totalUangTerima
        ];

        return $dataRes;
    }

    function del(Req $req, Res $res, array $args)
    {
        include("function/conn.php");
        $body = $req->getParsedBody();
        $idDel = $body["id"];
        $db->delete('detail_transaksi', ['id_transaksi' => $idDel]);
        $db->delete("transaksi", ["id" => $idDel]);
        return print_r("Success");
    }
}
