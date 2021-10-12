<?php 
    use \Psr\Http\Message\ServerRequestInterface as Req;
    use \Psr\Http\Message\ResponseInterface as Res;

require "db/conn.php";
    require 'vendor/autoload.php';
    $app = new \Slim\App;
    
    $app->get('/', function (Req $req, Res $res, $args) {    
        return require "root.php";
    });

    $app->get("/add", function ($req, $res, $args) {
        return require "add.php";
    });

    $app->post("/add", function (Req $req, Res $res, $args) {
        // $req->getBody()->getContents("");
        // $req->getBody()->;
        // return $args;
        return require "addDb.php";
    });

    $app->run();
?>