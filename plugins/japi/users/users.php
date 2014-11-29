<?php

// no direct access
defined('_JEXEC') or die();
JLoader::import('joomla.application.plugin');


// in an other file 
abstract class JPluginAPI extends JPlugin
{
    //all hight level stuff
}

class plgJapiUsers extends JPluginAPI
{

    public function getRoutes()
    {
        $route = '/users/:id';      // route based on Slim syntax
        $via = array('GET');
        $function = 'Users';        //  name of the callBack function for the route
        $origin = get_class($this); //  give the name of the class for the router
        //we create a new route objects
        $route = new routeDefinition($route, $via, $function, $origin);

        //this array of routes will be manage be an abstract class
        $routes = array($route);

        return $routes;
    }

    public function Users($params)
    {
        //To have the value of :id back
        //$params->params['id']
        
        $content= JFactory::getUser($params->params['id']);
        $data = new apiData($content, 200);

        return $data;
    }

}

/// 
class apiData
{

    public $msg;
    public $status;

    public function __construct($msg, $status)
    {
        //Place to add validation to prevent crazy values
        $this->msg = $msg;
        $this->status = $status;
    }

}

class routeDefinition
{

    public $route;
    public $via;
    public $function;
    public $origin;

    public function __construct($route, $via, $function, $origin)
    {

        //Place to add validation to prevent crazy values
        $this->origin = substr($origin, 7); // plgJapiUsers -> Users  
        $this->route = $route;
        $this->via = $via;
        $this->function = $function;
    }

}
?>