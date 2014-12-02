<?php
/**
 * @version     api/v1/routes.php 2014-11-21 13:46:00 UTC pav
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE);
 
$app->_db = JFactory::getDbo();
$app->view(new \ApiView());
$app->add(new \ApiMiddleware());

$request_method = strtolower($app->environment['REQUEST_METHOD']);

\jimport('joomla.application.web.router.base');
\jimport('joomla.application.web.router.rest');

//$router = new \JApplicationWebRouterRest();
//$router->addMap('/test', 'testController');

//Main entry
$app->get('/', function() use ($app) {
    $app->render(200, array(
        'msg' => 'You reach the JAPI V1',
    ));
});


\JPluginHelper::importPlugin('japi');
			$dispatcher = \JEventDispatcher::getInstance();
			$apiClassRoutes = $dispatcher->trigger('getRoutes');

 foreach ($apiClassRoutes as $apiClassRoute)
 {
    foreach ($apiClassRoute as $route)
    {
        foreach ($route->via as $via)
        {            
            $app->map($route->route, function() use ($app, $route, $via) {
            
            $router = $app->router();
            
            $params = new stdClass;
            $params->via = $via;               
            $params->params = $router->getCurrentRoute()->getParams();
            $param = array($params);
             
            \JPluginHelper::importPlugin( 'japi', $route->origin);
            $dispatcher = \JEventDispatcher::getInstance();
            $data = $dispatcher->trigger( $route->function, $param );   
            
            $app->render($data[0]->status, 
                    array(
                    'msg' => $data[0]->msg
                    ));
                    
            })->via($via);
        }
    }    
}
