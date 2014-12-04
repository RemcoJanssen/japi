<?php

// no direct access
defined('_JEXEC') or die();
JLoader::import('joomla.application.plugin');

require_once(JPATH_ADMINISTRATOR . '/components/com_japi/classes/routeDefinition.php');
require_once(JPATH_ADMINISTRATOR . '/components/com_japi/classes/apiData.php');

// in an other file 
abstract class JPluginAPI extends JPlugin
{

    private $routes;
    private $hiddenProperties;

    public function routes()
    {
        $this->init();
        return $this->routes;
    }

    public function addRoute($route, $methods, $callback)
    {
        $routeDefinition = new routeDefinition($route, $methods, $callback);
        $this->routes[] = $routeDefinition;
    }

    public function output($data, $code = 200)
    {
        $data = $this->hiddenProperty($data);

        $output = new apiData($data, $status);
        return $output;
    }

    public function setHiddenProperty(array $fields)
    {
        $this->hiddenProperties = $fields;
    }

    private function hiddenProperty($data)
    {
        if (!$this->hiddenProperties)
        {
            return $data;
        };


        if (is_array($data))
        {
            foreach ($data as $record)
            {
                foreach ($this->$hiddenProperties as $fieldname)
                {
                    unset($record->$fieldname);
                }
            }
        } else
        {
            foreach ($this->hiddenFields as $fieldname)
            {
                unset($data->$fieldname);
            }
        }

        return $data;
    }

    public function init()
    {
        
    }

    /**
     * Use this method to raise error
     * 
     * @throws \Exception
     */
    public function error($message, $code)
    {
        throw new \Exception($message, $code);
    }

}

?>