<?php
require_once '../../env.example.php';
if (!session_id()) session_start();

$configFiles = glob(__DIR__ . '/config/*.php');

foreach ($configFiles as $file) {
    require_once $file;
}

require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/App.php';

$app = new App();