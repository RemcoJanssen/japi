<?php
/**
 * @version     api/v1/functions.php 2014-22-05 14:21:00Z pav
 */

function authentificate()
{
    $Authentification = new \Tools\Authentification();
    $Authentification->Authentificate();
    
}
