<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

use BeeJee\Flamewalk\Router;
use BeeJee\Controller\MainController;
use Illuminate\Database\Capsule\Manager as Capsule;

$container = [];

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$container['renderer'] = new \Twig\Environment($loader);

// this should be in config obviously
$dsn = "pgsql:host=localhost;dbname=beejee";
$user = "postgres";
$passwd = "Passwerd1";

$container['db'] = new PDO($dsn, $user, $passwd);

$container['user'] = false;
if (isset($_SESSION['user']))
    $container['user'] = true;

$mainCon = new MainController($container);

Router::add('/', [$mainCon, 'index']);
Router::add('/taskList/([0-9]+)/([a-z0-9]+)/(asc|desc)', [$mainCon, 'taskList']);
Router::add('/edit/([0-9]+)', [$mainCon, 'edit'], 'post');
Router::add('/login', [$mainCon, 'login'], 'post');
Router::add('/logout', [$mainCon, 'logout']);
Router::add('/complete/([0-9]+)', [$mainCon, 'complete'], 'post');

Router::pathNotFound(function(){
    echo 'Pagerino doesnterino existerino';
});

Router::run('/');