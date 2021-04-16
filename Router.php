<?php

/* session_start(); */

require_once '../Config.php';
new \Config();

require_once '../Controller/Home.php';
require_once '../Controller/Blog.php';
require_once '../Controller/Post.php';
require_once '../View/View.php';


class Router {

  public $config;

  public function __construct() {
    $this->config = new Config();
    $this->ctrlHome = new \Controller\Home();
    $this->ctrlBlog = new \Controller\Blog();
    $this->ctrlPost = new \Controller\Post();
  }


  public function routerRequest() {

    $routes = $this->config->getRoutes();

    try {


      if ($routes[0] == 'blog') {

        if ($routes[1]) {

          $slug = $routes[1];
          $this->ctrlPost->show($slug);

        }

        else {

          $this->ctrlBlog->show();

        }


      }


      else if ($routes[0] == 'admin') {

        if ($routes[0] == 'addpost') {

        }

        else if ($routes[0] == 'deletepost') {

        }

        else {

          /* $this->ctrlAdmin->home(); */

        }


      }


      else {

        $this->ctrlHome->show();

      }


    }

    catch (Exception $e) {
      $this->error($e->getMessage());
    }

  }

  // Affiche une erreur
  private function error($errorMsg) {

    $view = new \View("Error");
    $view->render(array('errorMsg' => $errorMsg));
  }

}

?>