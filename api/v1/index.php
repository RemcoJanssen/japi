<?php
/**
 * @version     api/v1/index.php 2014-07-02 10:48:00 UTC ym 
 */

require_once 'init.php';

$app = new \Slim\Slim(array(
    'mode' => 'development'
        ));

require_once 'routes.php';

$app->run();
?>
