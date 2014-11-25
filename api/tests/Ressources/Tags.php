<?php
/**
 * @version     test/Ressources/Tags.php 2014-07-11 11:30:00 UTC pav
 */
class TagsTest extends Slim_Framework_TestCase
{
    /**
     * Test tag data
     * @var array $testTag
     */
    private $testTag = array(
        "id" => 0,
        "name" => "testtag",
        "type" => "success");
    /**
     * It will contain the ID of the newly created tag. We use a static so
     * it can be reused between tests
     * 
     * @var int $testSiteID
     */
    static private $testTagID;

    /**
     * GET /Tags/metadata
     * Check that you get a 200 response
     */
    public function testGetMetadata()
    {
        $this->rest('GET', '/tags/metadata');
        $this->assertEquals(200, $this->response->status);
    }

    /**
     * GET /Tags/
     * Check that you get a some tags in this account 
     */
    public function testGetTotal()
    {
        $this->rest('GET', '/tags');
        $this->assertEquals(200, $this->response->status);
        $response = $this->jsonToObject($this->response->body);
        $this->assertTrue(is_int($response->total), 'Wrong total');
    }

    /**
     * GET /Tags/
     * Check that the number of tags returned is 1 
     */
    public function testGetLimit()
    {
        $this->rest('GET', '/tags?limit=1');
        $this->assertEquals(200, $this->response->status);
        $response = $this->jsonToObject($this->response->body);
        $this->assertEquals(count($response->data), 1);
    }

    /**
     * GET /Tags/
     * Check we received only specific fields
     */
    public function testGetFields()
    {
        $this->rest('GET', '/tags?fields=id,name&limit=1');
        $this->assertEquals(200, $this->response->status);
        $response = $this->jsonToObject($this->response->body);
        $firstElement = $response->data[0];
        $this->assertEquals(count((array) $firstElement), 2);
        $this->assertTrue(property_exists($firstElement, 'id'), 'id is missing');
        $this->assertTrue(property_exists($firstElement, 'name'), 'name is missing');
    }

    /**
     * GET /Tags/
     * Check the search 
     */
    public function _testGetSearch()
    {
        $this->rest('GET', '/tags?log_entry=%25Joomla%25&limit=1');
        $this->assertEquals(200, $this->response->status);
        $response = $this->jsonToObject($this->response->body);
        $firstElement = $response->data[0];
        $this->assertTrue(0 < preg_match("/Joomla/i", $firstElement->log_entry), 'Joomla not found in log');
    }

    /**
     * GET /Tags/
     * Check the order 
     */
    public function testGetOrderAsc()
    {
        $this->rest('GET', '/tags?order=name+&limit=4');
        $this->assertEquals(200, $this->response->status);
        $response = $this->jsonToObject($this->response->body);
        $name = '';
        foreach ($response->data as $element)
        {
            $this->assertTrue($element->name >= $name, "Wrong order $element->name>=$name");
            $name = $element->name;
        }
    }

    /*
     * Test POST
     * Check that tpye & name of the new created tag are equal to our test data
     */

    public function testPostTag()
    {
        $this->rest('POST', '/tags', json_encode($this->testTag));
        $this->assertEquals(201, $this->response->status);

        $data = $this->jsonToObject($this->response->body);
        self::$testTagID = $data->id;

        $this->assertEquals($this->testTag['name'], $data->name);
        $this->assertEquals($this->testTag['type'], $data->type);
    }

    /**
     * GET /tags/id
     * Check a specific tag by id
     * 
     * @depends testPostTag
     */
    public function testGetTagsId()
    {
        $this->rest('GET', '/tags/' . self::$testTagID);
        $this->assertEquals(200, $this->response->status);
        $data = $this->jsonToObject($this->response->body);
        $this->assertEquals(self::$testTagID, $data->id);
        $this->assertEquals($this->testTag['name'], $data->name);
    }

    /**
     * PUT /tags/id
     * Modify a tag and controle the new value
     * 
     * @depends testPostTag
     */
    public function testPutTagsId()
    {
        $editTag = $this->testTag;
        $editTag['name'] = 'testtag - edited';

        $this->rest('PUT', '/tags/' . self::$testTagID, json_encode($editTag));
        $this->assertEquals(200, $this->response->status);

        $data = $this->jsonToObject($this->response->body);
        $this->assertEquals(self::$testTagID, $data->id);
        $this->assertEquals($editTag['name'], $data->name);
    }

    /**
     * DELETE /site/id
     * Delete an existing tag
     * 
     * @depends testPostTag
     */
    public function testDeleteTagsId()
    {
        $this->rest('DELETE', '/tags/' . self::$testTagID);
        $this->assertEquals(200, $this->response->status);
    }

    /**
     * @depends testDeleteTagsId
     * Delete a non existing tag
     * 
     */
    public function testDeleteNoExistingTagsId()
    {
        $this->rest('DELETE', '/tags/' . self::$testTagID);
        $this->assertEquals('{"error":true,"msg":"ERROR: Invalid id","status":400}', $this->response->body);
        $this->assertEquals(400, $this->response->status);
    }

}
