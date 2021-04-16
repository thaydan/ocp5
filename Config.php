<?php

class Config {

  public static $site_root;
  public static $site_root_admin;
  public static $site_root_absolute;
  public static $routes;

  public function __construct() {

    $site_root = 'https://ocp5.rominfo.fr';
    $site_root_admin = $site_root . '/admin';
    $site_root_absolute = '/homepages/9/d827568207/htdocs/rominfo/openclassrooms/projet-5';

    static::$site_root = $site_root;
    static::$site_root_admin = $site_root_admin;
    static::$site_root_absolute = $site_root_absolute;

  }

  public function getRoutes(){

    $routes = $_SERVER['REQUEST_URI'];
    $routes = substr($routes, 1);
    $routes = explode("/", $routes);

    return $routes;

  }

}

?>