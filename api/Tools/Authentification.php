<?php
/**
 * @version     Tools/Authentification.php 2014-11-16 11:30:00 UTC pav
 * @package     Watchful API
 * @author      Watchful
 * @authorUrl   https://watchful.li
 * @copyright   (c) 2014, Watchful
 */
namespace Tools;
class Authentification
{

    /**
     * Authentificate from a key
     * @return boolean
     */
     public function Authentificate()
    {
        $app = \Slim\Slim::getInstance();
        $app->environment['PATH_INFO'] = strtolower($app->environment['PATH_INFO']);
        $user = \JFactory::getUser();

        /*
        //user is not logged
        if ($user->guest)
        {
            $api_key = $this->getKey($app);
            $user = $this->getUser($app, $api_key);
        }
        
        $app->user = $user;
        $this->checkAcl($app);
        */
        
        $app->dataDogsTags->userid = $user->id;
        return true;
    }

    /**
     * Get the key from URL or header
     * use Slim framework for input
     * @param type $app
     * @return type
     * @throws \Exception
     */
    private function getKey($app)
    {

        if (isset($app->environment['api_key']))
        {
            return $app->environment['api_key'];
        }

        if ($app->request->headers->get('api_key'))
        {
            return $app->request->headers->get('api_key');
        }

        if ($app->request->get('api_key'))
        {
            return $app->request->get('api_key');
        }

        throw new \Exception('Invalid API key', 403);
    }

    /**
     * Get a user from a token
     * 
     * @param \Slim $app
     * @param string $api_key
     * @return JUser
     * @throws Exception
     */
    private function getUser($app, $api_key)
    {
        $app->_db->setQuery("SELECT * FROM #__api_keys WHERE hash = '" . $api_key . "'");
        $token = $app->_db->loadObject();

        if (!$token or !$token->published)
        {
            throw new \Exception('Not authorize Key', 404);
        }

        return $user = \JFactory::getUser($token->user_id);
    }
    
    /**
     * Access control based on requested route
     * 
     * @param \Slim $app
     * @throws \Exception
     */
    private function checkAcl($app)
    {
        return true;
    }
    


}
