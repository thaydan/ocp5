<?php

namespace Controller;

require_once '../View/View.php';

class Home {

  public function __construct() {
  }

  public function show() {

    $head_title = 'Romain Royer';

    $view = new \View("Home");
    $view->render(array('head_title' => $head_title));

  }

}