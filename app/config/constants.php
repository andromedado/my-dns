<?php
define('PERMIT_DEBUG', true);
define('DEFAULT_SITE_HOST', 'radcanon.com');
define('MAIL_FROM', 'Info <info@' . DEFAULT_SITE_HOST . '>');
define('APP_SUB_DIR' , '');//No Trailing Slash

define('DS', DIRECTORY_SEPARATOR);
define('APP_DIR', dirname(__DIR__) . DS);
define('APP_ROOT', dirname(APP_DIR) . DS);
define('LIB_DIR', APP_ROOT . 'lib' . DS);
define('RADCANON_DIR', LIB_DIR . 'radcanon' . DS);
define('DEBUG', PERMIT_DEBUG && isset($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1')));
define('OUTPUT_BUFFER', !DEBUG);
define('CONFIG_DIR', __DIR__ . DS);//With Trailing Slash
if (empty($_SERVER['HTTP_HOST'])) $_SERVER['HTTP_HOST'] = DEFAULT_SITE_HOST;
define('SITE_HOST', $_SERVER['HTTP_HOST']);
if (empty($_SERVER['REQUEST_URI'])) $_SERVER['REQUEST_URI'] = '/';
define('CURRENT_PROTOCOL', 'http' . (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443 ? 's' : '') . '://');
define('BASE_URL', CURRENT_PROTOCOL . SITE_HOST);
define('APP_CLASS_DIR', APP_DIR . 'classes' . DS);
define('CACHE_DIR', APP_DIR . 'cache' . DS);
define('LOG_FILE', CACHE_DIR . 'app.log');
define('TEMPLATE_CACHE_DIR', CACHE_DIR . 'templates');
define('APP_TEMPLATES_DIR', APP_DIR . 'views' . DS);
define('SERVER_PREFIX', APP_DIR . 'webroot');//No Trailing Slash
define('WEBROOT_DIR', SERVER_PREFIX . DS);
define('UPDIR_ROOT', WEBROOT_DIR . 'uploads' . DS);//With Trailing Slash
define('IMAGE_NOT_FOUND_FILE', WEBROOT_DIR . 'images' . DS . 'notFound.jpg');
define('IMAGE_NOT_FOUND_TYPE', 'image/jpeg');

define('NAMED_CONF_DIR', APP_DIR . 'named' . DS);
define('ZONES_DIR', NAMED_CONF_DIR . 'zones' . DS);
