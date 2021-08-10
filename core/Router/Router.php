<?php


namespace Core\Router;


class Router {

    private $url;
    private $routes = [];
    private $namedRoutes = [];

    public function __construct($url){
        $this->url = $url;
    }

    public function get($path, $callable, $name = null, $login = null){
        return $this->add($path, $callable, $name, 'GET', $login);
    }

    public function post($path, $callable, $name = null, $login = null){
        return $this->add($path, $callable, $name, 'POST', $login);
    }

    private function add($path, $callable, $name, $method, $login){
        $redirect = false;
        if ($login == 'admin' && !isset($_SESSION['id'])) {
            $redirect = true;
        }

        $route = new Route($path, $callable, $redirect);
        $this->routes[$method][] = $route;
        if(is_string($callable) && $name === null){
            $name = $callable;
        }
        if($name){
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    public function run(){
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new \Exception('REQUEST_METHOD does not exist');
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match($this->url)){
                return $route->call();
            }
        }
        throw new \Exception('No matching routes');
    }

    public function url($name, $params = []){
        if(!isset($this->namedRoutes[$name])){
            throw new \Exception('No route matches this name');
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }

}