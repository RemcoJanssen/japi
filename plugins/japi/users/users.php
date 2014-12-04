<?php

// no direct access
defined('_JEXEC') or die();
require_once(JPATH_ADMINISTRATOR . '/components/com_japi/classes/pluginApi.php');

class plgJapiUsers extends JPluginAPI
{

    public function getRoutes()
    {
        $this->addRoute('/users/:id',array('GET'),'Users');

        return $this->routes();
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

        return $this->output($data);
    }

}

?>