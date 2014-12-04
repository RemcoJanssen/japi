<?php

// no direct access
defined('_JEXEC') or die();


/// 
class apiData
{

    public $msg;
    public $status;

    public function __construct($data, $status=200)
    {
        //Place to add validation to prevent crazy values
        $this->msg = $data;
        $this->status = $status;
    }

}

?>