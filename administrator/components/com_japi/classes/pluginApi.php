<?php

// no direct access
defined('_JEXEC') or die();
JLoader::import('joomla.application.plugin');

// in an other file 
abstract class JPluginAPI extends JPlugin
{

    private $routes;

    public function Routes()
    {
        return $this->routes;
    }

    public function addRoute(routeDefinition $route)
    {
        $this->routes[] = $route;
    }

    /**
     * Use this method to raise error
     * 
     * @throws \Exception
     */
    public function error($message, $code)
    {
        throw new \Exception($message, $code);
    }

}

?>