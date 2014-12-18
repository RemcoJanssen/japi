<?php

// no direct access
defined('_JEXEC') or die();
require_once(JPATH_ADMINISTRATOR . '/components/com_japi/classes/pluginApi.php');

class plgJapiContacts extends JPluginAPI
{
    public function init()
    {   
        $this->setHiddenProperty(array('tags->itemTags'));   
    }
    
    public function getRoutes()
    {
        $this->addRoute('/contacts/:id', array('GET'), 'contact');
        $this->addRoute('/contacts', array('GET'), 'contacts');

        return $this->routes();
    }

    public function contact($params)
    {
        require_once(JPATH_BASE . '/components/com_contact/models/contact.php');
        $ContactModel = new ContactModelContact();

        $contact = $ContactModel->getItem($params->params['id']);
        return $this->output($contact);
    }

    public function contacts($params)
    {
        require_once(JPATH_ROOT . '/administrator/components/com_contact/models/contacts.php');
        $ContactModel = new ContactModelContacts();
        $contacts = $ContactModel->getItems();
        return $this->output($contacts);     
    }

}

?>
