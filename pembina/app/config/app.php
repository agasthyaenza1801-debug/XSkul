<?php

// identitas Aplikasi
define('APP_NAME', getenv('APP_NAME'));
define('APP_URL', getenv('APP_URL'));

// environment aplikasi
define('APP_ENV', getenv("APP_ENV") ?? 'production');
define('APP_DEBUG', APP_ENV === 'development');

// zona waktu
define('APP_TIMEZONE', getenv('APP_TIMEZONE'));

// list role
define('APP_ROLES', ['admin', 'pembina', 'siswa']);

// zona waktu berdasarkan konfigurasi setiap developer
date_default_timezone_set(APP_TIMEZONE);