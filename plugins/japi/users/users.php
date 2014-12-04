<?php

// no direct access
defined('_JEXEC') or die();
require_once(JPATH_ADMINISTRATOR . '/components/com_japi/classes/pluginApi.php');

class plgJapiUsers extends JPluginAPI
{

    public function init()
    {
        $this->setHiddenProperty(array('password'));
    }

    public function getRoutes()
    {
        $this->addRoute('/users/:id', array('GET'), 'users');

        return $this->routes();
    }

    public function users($params)
    {
        $user = JFactory::getUser($params->params['id']);

        if ($user->guest == 1)
        {
            $this->error('Not exist', 404);
        }

        return $this->output($user);
    }

}

?>