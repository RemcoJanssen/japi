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

    /*
     * Return the list of route
     */
    public function routes()
    {
        $this->init();
        return $this->routes;
    }
/*
 * Define a route used by the router
 */
    public function addRoute($route, $methods, $callback)
    {
        $routeDefinition = new routeDefinition($route, $methods, $callback);
        $this->routes[] = $routeDefinition;
    }
/*
 * Generic method to send data to the API
 */
    public function output($data, $code = 200)
    {
        //Remove unwanted properties
        $data = $this->hiddenProperty($data);

        $output = new apiData($data, $status);
        return $output;
    }

    /*
     * Set the properties that have to be removed from the output
     */

    public function setHiddenProperty(array $fields)
    {
        $this->hiddenProperties = $fields;
    }

    /*
     * Remove some propeties from an object or an array of objects
     */

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
                foreach ($this->hiddenProperties as $fieldname)
                {
                    unset($record->$fieldname);
                }
            }
        } else
        {
            foreach ($this->hiddenProperties as $fieldname)
            {
                unset($data->$fieldname);
            }
        }

        return $data;
    }

    public function init()
    {
        
    }

    /*
     * Shortcut for Bad request error
     */

    public function badRequest()
    {
        $this->error('Bad Request', 400);
    }

    /*
     * Shortcut for forbidde error
     */

    public function forbidden()
    {
        $this->error('Forbidden', 403);
    }

    /*
     * Shortcut for notFound error
     */

    public function notFound()
    {
        $this->error('Not Found', 404);
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