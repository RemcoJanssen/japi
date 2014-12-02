<?php
/**
 * @version     frontend/controller.php 2013-08-13 14:21:00Z zanardi
 * @package     Watchful Master
 * @author      Watchfuls
 * @copyright   (c) 2012-2013, Watchful
 */
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-Type:application/json; charset=utf8');
echo file_get_contents ('api-docs.json');