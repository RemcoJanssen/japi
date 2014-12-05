<?php

// no direct access
defined('_JEXEC') or die();
require_once(JPATH_ADMINISTRATOR . '/components/com_japi/classes/pluginApi.php');

class plgJapiUsers extends JPluginAPI
{

    public function init()
    {
        //This function remove the "password" field from the output
        $this->setHiddenProperty(array('password'));
    }

    public function getRoutes()
    {
        //HTTP GET request for “/users/34” will invoke the associated callback function, passing “34” as the callback’s argument
        $this->addRoute('/users/:id', array('GET'), 'users');

        return $this->routes();
    }

    public function users($params)
    {
        //$params->params is an array of the variable used into the route : /users/:id
        $user = JFactory::getUser($params->params['id']);

        if ($user->guest == 1)
        {
            //This is a shortcut to 'Not found' - 404
            $this->notFound();
        }

        return $this->output($user);
    }
}

?>
