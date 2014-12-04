<?php

// no direct access
defined('_JEXEC') or die();
require_once(JPATH_ADMINISTRATOR . '/components/com_japi/classes/pluginApi.php');

class plgJapiContacts extends JPluginAPI
{

    public function getRoutes()
    {
        $this->addRoute('/contacts/:id', array('GET'), 'Contact');
        $this->addRoute('/contacts', array('GET'), 'Contacts');

        return $this->Routes();
    }

    public function Contact($params)
    {
        include(JPATH_BASE . '/components/com_contact/models/contact.php');
        $ContactModel = new ContactModelContact();

        $data = $ContactModel->getItem($params->params['id']);
        return new apiData($data);
    }

    public function Contacts($params)
    {
        require_once JPATH_ROOT . '/administrator/components/com_contact/models/contacts.php';
        $ContactModel = new ContactModelContacts();
        $contacts = $ContactModel->getItems();
        return new apiData($contacts);      
    }

}

?>