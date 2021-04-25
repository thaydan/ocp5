<?php

use Symfony\Component\Dotenv\Dotenv;
use App\Router\Router;
use App\Controller\Home;

require '../vendor/autoload.php';


$envFiles = ['../.env'];
if (file_exists('../.env.local')) {
    $envFiles[] = '../.env.local';
}

//var_dump($envFiles);

$dotenv = new Dotenv();
$dotenv->load(...$envFiles);

//require '../Router.php';

$router = new Router($_GET['url']);

$router->get('/', (new Home())->show());
$router->get('/blog', function (){ echo 'Tous les articles'; });
$router->get('/blog/:slug', function ($id){ echo "Article $slug"; });
$router->post('/blog/:id', function ($id){ echo "Poster pour l'article $id"; });

//$router->put();
//$router->delete();

$router->run();