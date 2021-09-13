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

$_GET = filter_input_array(INPUT_GET);
$_POST = filter_input_array(INPUT_POST);

$envFiles = ['../.env'];
if (file_exists('../.env.local')) {
    $envFiles[] = '../.env.local';
}

$dotenv = new Dotenv();
$dotenv->load(...$envFiles);

session_start();

if(isset($_SESSION['current-route'])) {
    $_SESSION['last-route'] = $_SESSION['current-route'];
}
$_SESSION['current-route'] = $_GET['url'];

$router = new Router($_GET['url']);

$router->get('/', [new HomeController, 'show'], 'home');

$router->get('/contact', [new ContactController, 'show'], 'contact');
$router->post('/contact', [new ContactController, 'send'], 'contact');
$router->get('/login', [new LoginController, 'login'], 'login');
$router->post('/login', [new LoginController, 'login'], 'login');
$router->get('/logout', [new LogoutController, 'logout'], 'logout');

/* admin routes */
$router->get('/profile', [new ProfileController, 'show'], 'profile', 'admin');
$router->post('/profile', [new ProfileController, 'show'], 'profile', 'admin');
$router->get('/user/:id/delete', [new ProfileController, 'deleteUser'], 'deleteUser', 'admin');
$router->get('/blog/edit-post',  [new EditPostController, 'edit'], 'newPost', 'admin');
$router->post('/blog/edit-post',  [new EditPostController, 'edit'], 'newPost', 'admin');
$router->get('/blog/edit-post/:slug',  [new EditPostController, 'edit'], 'editPost', 'admin');
$router->post('/blog/edit-post/:slug',  [new EditPostController, 'edit'], 'editPost', 'admin');
$router->get('/blog/delete-post/:slug',  [new EditPostController, 'delete'], 'deletePost', 'admin');
$router->get('/comment/:id/validate',  [new CommentController, 'validate'], 'validateComment', 'admin');
$router->get('/comment/:id/delete',  [new CommentController, 'delete'], 'deleteComment', 'admin');
// end if logged


$router->get('/blog', [new BlogController, 'show'], 'blog');
$router->get('/blog/:slug',  [new PostController, 'show'], 'blogPost');
$router->post('/blog/:slug',  [new PostController, 'addComment'], 'blogPost');
$router->get('/mentions-legales', [new LegalNoticeController, 'show'], 'legalNotice');

try {
    $router->run();
} catch (Exception $e) {
    $error = new ErrorController();
    $error->defaultError($e->getMessage());
}
