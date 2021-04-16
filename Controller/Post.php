<?php

namespace Controller;

require_once '../Model/Post.php';
require_once '../View/View.php';

class Post {

  private $post;

  public function __construct() {
    $this->post = new \Model\Post();
  }

  public function show($slug) {

    $post = $this->post->getPost($slug);

    $head_title = $post['title'] . ' - Romain Royer';

    $view = new \View("Post");
    $view->render(array('head_title' => $head_title,
                        'post' => $post
                       ));
  }
}