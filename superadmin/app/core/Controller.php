<?php

class Controller {
    public function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/' . $view . '.php';
    }

    public function template($template, $data = []) {
        extract($data);
        require_once __DIR__ . '/../templates/' . $template . '.php';
    }

    public function model($model) {
        require_once __DIR__ . '/../models/' . $model . '.php';
        return new $model;
    }
}
