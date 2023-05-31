<?php

require_once __DIR__ . '/../vendor/autoload.php';

//phpinfo();
//echo "<pre>";
//var_dump(apache_request_headers());

$app = new \app\core\Application();

$routesClosure = include_once \app\core\Application::ROOT_DIR.'/routes/web.php';

call_user_func($routesClosure, $app);

$app->run();
exit();
