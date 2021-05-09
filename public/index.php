<?php

use App\Controller\Login;
use Symfony\Component\Dotenv\Dotenv;
use Core\Router\Router;
use App\Controller\Home;
use App\Controller\Blog;
use App\Controller\Post;
use App\Controller\Contact;

require '../vendor/autoload.php';


$envFiles = ['../.env'];
if (file_exists('../.env.local')) {
    $envFiles[] = '../.env.local';
}

$dotenv = new Dotenv();
$dotenv->load(...$envFiles);

$router = new Router($_GET['url']);

$router->get('/', [new Home, 'show']);
$router->get('/blog', [new Blog, 'show']);
//$router->get('/blog/:slug',  [new Post, 'show']);
$router->post('/blog/:id', function ($id){ echo "Poster pour l'article $id"; });

$router->get('/contact', [new Contact, 'show']);
$router->get('/login', [new Login, 'login']);

//$router->put();
//$router->delete();

$router->run();