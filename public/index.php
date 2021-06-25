<?php

use App\Controller\DashboardController;
use App\Controller\LogoutController;
use Symfony\Component\Dotenv\Dotenv;
use Core\Router\Router;
use App\Controller\HomeController;
use App\Controller\BlogController;
use App\Controller\PostController;
use App\Controller\EditPostController;
use App\Controller\ContactController;
use App\Controller\LoginController;
use App\Controller\ProfileController;

require '../vendor/autoload.php';


$envFiles = ['../.env'];
if (file_exists('../.env.local')) {
    $envFiles[] = '../.env.local';
}

$dotenv = new Dotenv();
$dotenv->load(...$envFiles);

session_start();

$router = new Router($_GET['url']);

$router->get('/', [new HomeController, 'show']);

$router->get('/contact', [new ContactController, 'show']);
$router->get('/login', [new LoginController, 'login']);
$router->post('/login', [new LoginController, 'login']);
$router->post('/festival', [new LoginController, 'login']);
$router->get('/logout', [new LogoutController, 'logout']);

// if logged
$router->get('/profile', [new ProfileController, 'show']);
$router->get('/dashboard', [new DashboardController, 'dashboard']);
$router->get('/blog/edit-post',  [new EditPostController, 'edit']);
$router->get('/blog/edit-post/:slug',  [new EditPostController, 'edit']);
$router->post('/blog/edit-post',  [new EditPostController, 'edit']);
$router->post('/blog/edit-post/:slug',  [new EditPostController, 'edit']);
//$router->get('/edit-post/:id', [new DashboardController, 'dashboard']);
// end if logged


$router->get('/blog', [new BlogController, 'show']);
$router->get('/blog/:slug',  [new PostController, 'show']);
//$router->post('/blog/:id', function ($id){ echo "Poster pour l'article $id"; });

//$router->put();
//$router->delete();

$router->run();
