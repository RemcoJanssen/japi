<?php

// no direct access
defined('_JEXEC') or die();


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