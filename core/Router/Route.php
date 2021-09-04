<?php


namespace Core\Router;


class Route
{

    private $path;
    private $callable;
    private $matches = [];
    public $redirect;

    public function __construct($path, $callable, $redirect = null)
    {
        $this->path = trim($path, '/');  // On retire les / inutils
        $this->callable = $callable;
        $this->redirect = $redirect;
    }

    /**
     * Permettra de capturer l'url avec les paramètre
     * get('/posts/:slug-:id') par exemple
     **/
    public function match($url): bool
    {
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;  // On sauvegarde les paramètre dans l'instance pour plus tard
        return true;
    }

    public function call()
    {
        if ($this->redirect) {
            header('Location: /');
            exit();
        }
        if (is_string($this->callable)) {
            $params = explode('#', $this->callable);
            $controller = "App\\Controller\\" . $params[0] . "Controller";
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

}