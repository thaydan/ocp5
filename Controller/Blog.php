<?php

namespace Controller;

require_once '../Model/Post.php';
require_once '../View/View.php';

class Blog {

  private $post;

  public function __construct() {
    $this->post = new \Model\Post();
  }

  public function show() {

    $head_title = 'Blog - Romain Royer';

    $posts = $this->post->getPosts();

    $view = new \View("Blog");
    $view->render(array('head_title' => $head_title,
                        'posts' => $posts
                       ));
  }
}