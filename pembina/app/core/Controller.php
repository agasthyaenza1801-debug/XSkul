<?php

class Controller {
    public function view($view, $data = []) {
        extract($data);
        require_once '../app/views/' . $view . '.php';
    }

    public function template($view, $data = []) {
        extract($data);
        require_once '../app/templates/' . $view . '.php';
    }

    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model;
    }
}