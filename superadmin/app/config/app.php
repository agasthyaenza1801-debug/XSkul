<?php

define('APP_NAME', 'XSkul');
define('APP_URL', $_ENV['APP_URL'] ?? 'http://localhost/xskul/superadmin/public');

define('APP_ENV', $_ENV['APP_ENV'] ?? 'production');
define('APP_DEBUG', APP_ENV === 'development');

define('APP_TIMEZONE', 'Asia/Jakarta');

date_default_timezone_set(APP_TIMEZONE);
