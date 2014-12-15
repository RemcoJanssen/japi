<?php
class ApiView extends \Slim\View
{

    public function render($template = NULL, $data = NULL, $status = 200)
    {
        $app = \Slim\Slim::getInstance();

        $status = intval($status);

        $response = $this->all();

//append error bool

        $response['error'] = $this->has('error');

//append status code
        $response['status'] = $status;

//remove flash messages
        unset($response['flash']);

        $app->response()->status($status);

        $format = $this->getBestFormat($app);

        if ($format == 'xml')
        {
            $this->xmlOutput($app, $response);
        }

        if ($format == 'txt')
        {
            $this->serializeOutput($app, $response);
        }

        $this->jsonOutput($app, $response);
    }

    private function jsonOutput($app, $response)
    {
        $app->response()->header('Content-Type', 'application/json');

        $jsonp_callback = $app->request->get('callback', null);

        if ($jsonp_callback !== null)
        {
            $app->response()->body($jsonp_callback . '(' . json_encode($response) . ')');
            $app->stop();
        }

        $app->response()->body(json_encode($response));
        $app->stop();
    }

    private function xmlOutput($app, $response)
    {
        $XMLEncoder = new \Tools\XMLEncoder();

        $app->response()->header('Content-Type', 'application/xml');
        $app->response()->body($XMLEncoder->generateValidXmlFromArray($response, 'api'));
        $app->stop();
    }

    private function serializeOutput($app, $response)
    {
        $app->response()->header('Content-Type', 'text/plain');
        $app->response()->body(serialize($response));
        $app->stop();
    }

    private function getBestFormat($app)
    {
        $negotiator = new \Negotiation\FormatNegotiator();
        $acceptHeader = $app->request->headers->get('accept');
        $priorities = array('application/json', 'application/xml', 'text/plain', '*/*');
        return $negotiator->getBestFormat($acceptHeader, $priorities);
    }

}
