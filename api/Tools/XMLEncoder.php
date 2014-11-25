<?php
/**
 * @version     Tools/XMLEncoder.php 2014-06-18 11:30:00 UTC pav
 */

namespace Tools;
class XMLEncoder {

    // functions adopted from http://www.sean-barton.co.uk/2009/03/turning-an-array-or-object-into-xml-using-php/

    /**
     * Generate Xml From an Obj
     * @param \Tools\stdClass $obj
     * @param type $node_block
     * @param type $node_name
     * @return type
     */
    public static function generateValidXmlFromObj(stdClass $obj, $node_block='nodes', $node_name='node') {
        $arr = get_object_vars($obj);
        return self::generateValidXmlFromArray($arr, $node_block, $node_name);
    }

    /**
     * Generate Valid Xml From an Array
     * @param type $array
     * @param type $node_block
     * @param type $node_name
     * @return string
     */
    public static function generateValidXmlFromArray($array, $node_block='nodes', $node_name='node') {
        $xml = '<?xml version="1.0" encoding="UTF-8" ?>';

        $xml .= '<' . $node_block . '>';
        $xml .= self::generateXmlFromArray($array, $node_name);
        $xml .= '</' . $node_block . '>';

        return $xml;
    }

    /**
     * Generate Xml From Array
     * @param type $array
     * @param type $node_name
     * @return type
     */
    private static function generateXmlFromArray($array, $node_name) {
        $xml = '';

        if (is_array($array) || is_object($array)) {
            foreach ($array as $key=>$value) {
                if (is_numeric($key)) {
                    $key = $node_name;
                }

                $xml .= '<' . $key . '>' . self::generateXmlFromArray($value, $node_name) . '</' . $key . '>';
            }
        } else {
            $xml = htmlspecialchars($array, ENT_QUOTES);
        }

        return $xml;
    }

}