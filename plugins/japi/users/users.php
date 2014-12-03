<?php

// no direct access
defined('_JEXEC') or die();

require_once(JPATH_ADMINISTRATOR . '/components/com_japi/classes/pluginApi.php');
require_once(JPATH_ADMINISTRATOR . '/components/com_japi/classes/routeDefinition.php');
require_once(JPATH_ADMINISTRATOR . '/components/com_japi/classes/apiData.php');

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
        $this->addRoute($route);

        return $this->Routes();
    }

    public function Users($params)
    {
        //To have the value of :id back
        //$params->params['id']

        $user = JFactory::getUser($params->params['id']);

        if ($user->guest == 1)
        {
            $this->error('Not exist', 404);
        }

        $data = new apiData($user);

        return $data;
    }

}

?>