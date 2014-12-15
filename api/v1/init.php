<?php
/**
 * @version     api/v1/init.php 2014-07-02 14:21:00Z pav
 */

define('_JEXEC', 1);
define('_API', 1);

define('JPATH_BASE', dirname(dirname(dirname(__FILE__))));

// Include the Joomla framework
require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';


$application = JFactory::getApplication('site');
$application->initialise();


require_once  '../Slim/Slim.php';
require_once  'functions.php';

\Slim\Slim::registerAutoloader();

