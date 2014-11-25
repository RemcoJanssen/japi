<?php
/**
 * @version       swagger.php 2014-05-07 14:49:00 UTC zanardi
 * @package       Watchful Master
 * @author        Watchful
 * @authorUrl     https://watchful.li
 * @copyright     (c) 2012-2014, Watchful
 * @description   web app to generate Swagger documentation from our API
 */

require __DIR__.'/vendor/autoload.php';
  
//ini_set("display_errors",0);

require '../api/Slim/Slim.php';
define('PATH_BASE', dirname(dirname(__FILE__)));

\Slim\Slim::registerAutoloader();

$api_root = PATH_BASE.'/api/Ressources';
$doc_root = PATH_BASE.'/api/v1/api-docs';

use Swagger\Swagger;
$swagger = new Swagger($api_root);

file_put_contents($doc_root.'/api-docs.json', $swagger->getResourceList(array('output' => 'json')));
echo "Created file: $doc_root/api-docs.json<br/>";
foreach ($swagger->getResourceNames() as $resource)
{
  file_put_contents($doc_root.'/'.$resource, $swagger->getResource($resource,array('output' => 'json')));
  echo "Created file: $doc_root/$resource<br/>";
}     
