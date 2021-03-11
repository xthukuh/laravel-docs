<?php
/**
*	error reporting
*/
error_reporting(E_ALL);
ini_set('display_errors', 'On');

/**
*	Autoload (see ./composer.json)
*/
require_once __DIR__ . '/vendor/autoload.php';

/**
*	global definitions
*/
define('IS_HTTPS', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on');
define('REQUEST_HTTP', IS_HTTPS ? 'https' : 'http');
define('REQUEST_HOST', sprintf('%s://%s', REQUEST_HTTP, $_SERVER['HTTP_HOST']));
define('REQUEST_BASE', trim(str_replace('index.php', '', $_SERVER['PHP_SELF'])));
define('REQUEST_BASE_URL', rtrim(sprintf('%s/%s', REQUEST_HOST, trim(REQUEST_BASE, '/')), '/'));
define('REQUEST_PATH', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
define('REQUEST_PATH_URL', rtrim(sprintf('%s/%s', REQUEST_HOST, trim(REQUEST_PATH, '/')), '/'));
define('LARAVEL_DOCS_DIR', __DIR__ . '/vendor/laravel/docs');
define('LARAVEL_DOCS_CACHE_DIR', __DIR__ . '/cache');

/**
*	Require Main
*/
require_once __DIR__ . '/src/index.php';
