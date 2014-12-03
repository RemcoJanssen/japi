<?php

// no direct access
defined('_JEXEC') or die();

require_once(JPATH_ADMINISTRATOR . '/components/com_japi/classes/pluginApi.php');
require_once(JPATH_ADMINISTRATOR . '/components/com_japi/classes/routeDefinition.php');
require_once(JPATH_ADMINISTRATOR . '/components/com_japi/classes/apiData.php');

class plgJapiContacts extends JPluginAPI
{

    public function getRoutes()
    {
        $route = '/contacts/:id';      // route based on Slim syntax
        $via = array('GET');
        $function = 'Contact';        //  name of the callBack function for the route
        $origin = get_class($this); //  give the name of the class for the router
        //we create a new route objects
        $route = new routeDefinition($route, $via, $function, $origin);
        $this->addRoute($route);

        return $this->Routes();
    }

    public function Contact($params)
    {
        include(JPATH_BASE . '/components/com_contact/models/contact.php');
        $ContactModel = new ContactModelContact();
        
        $data = $ContactModel->getItem($params->params['id']);
        return new apiData($data);
    }

}

?>