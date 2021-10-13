<?php

use \Psr\Http\Message\ServerRequestInterface as Req;
use \Psr\Http\Message\ResponseInterface as Res;

class IndexRoutes
{
    function get()
    {
        return require "public/pages/index.php";
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
