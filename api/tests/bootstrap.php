<?php
/**
 * @version     test/boostrap.php 2014-07-25 08:00:00 UTC chv
 */
class Slim_Framework_TestCase extends PHPUnit_Framework_TestCase
{
    private $baseUrl = '';
    protected static $apiKey = '';
    public $response;

    /**
     * This is the ID of a site which has a monitor id installed
     * 
     * @var int $uptimetestSiteID
     */
    public static $uptimeTestSiteID = 0;
    
    /**
     * Load current server configuration
     */
    public function __construct()
    {
        include('config.php');
    }

    /**
     * Rest CURL
     * @param string $method
     * @param string $uri
     * @param array $post
     * @param arry $header
     */
    public function rest($method, $uri, $post = NULL, $header = array())
    {
        $ch = curl_init();
        $defaultHeader = array(
            'api_key' => static::$apiKey
        );
        $curlHeader = array();

        $header = array_merge($defaultHeader, $header);

        //Format array for CURL
        foreach ($header as $key => $value)
        {
            $curlHeader[] = $key . ': ' . $value;
        }

        $options = array(
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_URL => $this->baseUrl . $uri,
            CURLOPT_CUSTOMREQUEST => $method, // GET POST PUT PATCH DELETE HEAD OPTIONS 
            CURLOPT_POSTFIELDS => $post,
            CURLOPT_HTTPHEADER => $curlHeader
        );

        //Set CURL params
        curl_setopt_array($ch, ($options));

        //Send request and get result
        $this->response->raw = curl_exec($ch);
        $this->response->status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $this->response->header = substr($this->response->raw, 0, $header_size);
        $this->response->body = substr($this->response->raw, $header_size);
    }

    /**
     * Return data object from json api message
     * @param string/json $json
     * @return array
     */
    public function jsonToObject($json)
    {
        $data = json_decode($json);
        return $data->msg;
    }

    /**
     * Return true if the key as egal to the value in array of object
     * @param string $key
     * @param string $val
     * @param array $array
     */
    public function keyEqualVal($key, $val, $array)
    {
        if (is_array($array))
        {
            foreach ($array as $object)
            {
                if (isset($object->$key) && $object->$key == $val)
                {
                    return true;
                }
            }
            return false;
        }
        if (isset($array->$key) && $array->$key == $val)
        {
            return true;
        }
    }

}
