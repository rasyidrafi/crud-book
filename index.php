<?php 
    require 'vendor/autoload.php';

    // Routes
    require "routes/index.php";
    require "routes/add.php";
    require "routes/print.php";

    $app = new \Slim\App;
    $container = $app->getContainer();
    $container['view'] = function ($container) {
        return new \Slim\Views\PhpRenderer('public/');
    };

    $app->get('/', function ($req, $res, $args) {
        $routes = new IndexRoutes;
        $data = $routes->get();
        return $this->view->render($res, 'pages/index.phtml', $data);
    });

    $app->delete("/", function ($req, $res, $args) {
        $routes = new IndexRoutes;
        $routes->del($req, $res, $args);
    });

    $app->get("/add", function ($req, $res, $args) {
        return $this->view->render($res, 'pages/add.phtml');
    });

    $app->post("/add", function ($req, $res, $args) {
        $routes = new AddRoutes;
        $routes->post($req, $res, $args);
    });

    $app->post('/print', function($req, $res, $args){
        $routes = new PrintRoutes;
        $data = $routes->post($req, $res, $args);
        return $this->view->render($res, 'pages/print.phtml', $data);
    });

    $app->run();
?>