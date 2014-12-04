<?php

// no direct access
defined('_JEXEC') or die();
JLoader::import('joomla.application.plugin');

require_once(JPATH_ADMINISTRATOR . '/components/com_japi/classes/routeDefinition.php');
require_once(JPATH_ADMINISTRATOR . '/components/com_japi/classes/apiData.php');

// in an other file 
abstract class JPluginAPI extends JPlugin
{

    private $routes;

    public function routes()
    {
        return $this->routes;
    }
    

    public function addRoute($route,$methods,$callback)
    {
        $routeDefinition = new routeDefinition($route,$methods,$callback);
        $this->routes[] = $routeDefinition;
    }

    public function output($data,$code=200)
    {
        $output = new apiData($data, $status);
        return $output;
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