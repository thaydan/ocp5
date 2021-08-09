<?php

use App\Controller\CommentController;
use App\Controller\ErrorController;
use App\Controller\LegalNoticeController;
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
$router->post('/contact', [new ContactController, 'send']);
$router->get('/login', [new LoginController, 'login']);
$router->post('/login', [new LoginController, 'login']);
$router->get('/logout', [new LogoutController, 'logout']);

// if logged
$router->get('/profile', [new ProfileController, 'show']);
$router->get('/blog/edit-post',  [new EditPostController, 'edit']);
$router->get('/blog/edit-post/:slug',  [new EditPostController, 'edit'], 'edit_post');
$router->post('/blog/edit-post/:slug',  [new EditPostController, 'edit'], 'edit_post');
$router->get('/blog/delete-post/:slug',  [new EditPostController, 'delete'], 'delete_post');
$router->post('/blog/edit-post',  [new EditPostController, 'edit']);
$router->post('/blog/edit-post/:slug',  [new EditPostController, 'edit']);
$router->get('/comment/:id/validate',  [new CommentController, 'validate']);
$router->get('/comment/:id/delete',  [new CommentController, 'delete']);
//$router->get('/edit-post/:id', [new DashboardController, 'dashboard']);
// end if logged


$router->get('/blog', [new BlogController, 'show']);
$router->get('/blog/:slug',  [new PostController, 'show']);
$router->post('/blog/:slug',  [new PostController, 'addComment']);
$router->get('/mentions-legales', [new LegalNoticeController, 'show']);

//$router->put();
//$router->delete();

try {
    $router->run();
} catch (Exception $e) {
    $error = new ErrorController();
    $error->defaultError($e->getMessage());
}
