<?php
/**
 * @version     api/v1/routes.php 2014-11-21 13:46:00 UTC pav
 */
$app->_db = JFactory::getDbo();
$app->view(new \ApiView());
$app->add(new \ApiMiddleware());

$request_method = strtolower($app->environment['REQUEST_METHOD']);


//Main entry
$app->get('/', function() use ($app) {
    $app->render(200, array(
        'msg' => 'You reach the JAPI V1',
    ));
});

\JPluginHelper::importPlugin('japi');
			$dispatcher = \JEventDispatcher::getInstance();
			$apiClassRoutes = $dispatcher->trigger('getRoutes');

<<<<<<< HEAD
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
=======

/* Tags */

//routes are hardcoded in this exemple, but  it's not a problem to configure them from a DB or Plugins
$app->map('/tags', 'authentificate', function() use ($app, $request_method) {
    $ressource = new \Ressources\Tags($app);
    $ressource->$request_method();
})->via('GET', 'POST','OPTIONS');

$app->map('/tags/:id', 'authentificate', function($id) use ($app, $request_method) {
    $ressource = new \Ressources\Tags($app, $id);
    $ressource->$request_method();
})->via('GET', 'DELETE', 'PUT','OPTIONS');
>>>>>>> cdd544e7e42ad2f8c1515ec98d7061e1d97c109f
