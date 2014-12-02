<?php

// no direct access
defined('_JEXEC') or die();
JLoader::import('joomla.application.plugin');


// in an other file 
abstract class JPluginAPI extends JPlugin
{
   /**
     * Use this method to raise error
     * 
     * @throws \Exception
     */
    public function error($message,$code)
    {
        throw new \Exception($message, $code);
    }
}

?>