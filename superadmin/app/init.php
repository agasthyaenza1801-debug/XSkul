<?php
require_once '../../env.example.php';
putenv('APP_URL=http://localhost/XSkul/superadmin/public');
if (!session_id()) session_start();

foreach (glob(__DIR__ . '/config/*.php') as $file) {
    require_once $file;
}

require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/App.php';

$app = new App();
