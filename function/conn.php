<?php 
require 'vendor/autoload.php';

$config = [
    'DB_DRIVER'      => 'mysql',
    'DB_HOST'        => 'localhost',
    'DB_USER'        => 'user',
    'DB_PASS'        => 'test123',
    'DB_NAME'        => 'lamda_book',
  ];
  
  $db = new Cahkampung\Landadb($config);
?>