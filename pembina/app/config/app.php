<?php

// Identitas Aplikasi
define('APP_NAME', 'XSkul');
define('APP_URL', 'http://localhost/XSkul/pembina/public');

// Environment & Debugging
define('APP_ENV', $_ENV['APP_ENV'] ?? 'production');
define('APP_DEBUG', APP_ENV === 'development');

// Regional
define('APP_TIMEZONE', 'Asia/Jakarta');

/*
 * Namespace → prefix URL
 * Karena 'roles' adalah array, kita bisa mendefinisikannya 
 * dalam bentuk array (didukung sejak PHP 7.0)
 */
define('APP_ROLES', ['admin', 'pembina', 'siswa']);

// Set timezone secara otomatis berdasarkan konstanta di atas
date_default_timezone_set(APP_TIMEZONE);