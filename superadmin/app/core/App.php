<?php

class App {
    protected $controller = 'Auth';
    protected $method     = 'index';
    protected $params     = [];

    public function __construct() {
        $url = $this->parseURL();

        if (isset($url[0])) {
            $file = __DIR__ . '/../controllers/' . ucfirst($url[0]) . '.php';
            if (file_exists($file)) {
                $this->controller = $url[0];
                unset($url[0]);
            }
        }

        require_once __DIR__ . '/../controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = !empty($url) ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}
