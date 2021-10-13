<?php 
    require 'vendor/autoload.php';

    // Routes
    require "routes/index.php";
    require "routes/add.php";
    require "routes/print.php";

    $app = new \Slim\App;

    $app->get('/', function ($req, $res, $args) {
        $routes = new IndexRoutes;
        return $routes->get();
    });

    $app->delete("/", function ($req, $res, $args) {
        $routes = new IndexRoutes;
        $routes->del($req, $res, $args);
    });

    $app->get("/add", function ($req, $res, $args) {
        $routes = new AddRoutes;
        $routes->get();
    });

    $app->post("/add", function ($req, $res, $args) {
        $routes = new AddRoutes;
        $routes->post($req, $res, $args);
    });

    $app->post('/print', function($req, $res, $args){
        $routes = new PrintRoutes;
        $routes->post();
    });

    $app->run();
?>