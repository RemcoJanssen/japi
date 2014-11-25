<?php
/**
 * @version     Ressources/Tags.php 2014-07-30 07:48:00 UTC ch
 */

namespace Ressources;
/**                                            
 * @SWG\Model(id="Tag")

 * @SWG\Property(
 *   name="id",
 *   description="Unique identifier for the tag",
 *   type="integer",
 *   format="int64",
 *   required=true
 * )

 * @SWG\Property(
 *   name="title",
 *   type="string",
 *   description="Friendly name for the tag",
 *   required=true
 * )

 * @SWG\Property(
 *   name="alias",
 *   type="string",
 *   description="URL alias"
 * )
 * 
 * @SWG\Property(
 *   name="language",
 *   type="string",
 *   description="Language value like fr-FR",
 *   required=false
 * )
 */
/**
 * @SWG\Resource(
 *   apiVersion="1.0.0",
 *   swaggerVersion="1.2",
 *   basePath="/api/v1",
 *   resourcePath="/tags",
 *   description="Operations about tags",
 *   produces="['application/json','application/xml','text/plain']"
 * )
 */
class Tags extends Ressources
{

    /**
     * @SWG\Api(
     *   path="/tags",
     *   @SWG\Operation(
     *     method="GET",
     *     summary="Get a list of tags",
     *     notes="Returns a list of tags",
     *     type="Tag",
     *     nickname="getTags",
     *     @SWG\Parameter(
     *       name="title",
     *       description="Do a 'LIKE' search, you can also use '%'",
     *       required=false,
     *       type="string",
     *       paramType="query"
     *     ),
     *     @SWG\Parameter(
     *       name="fields",
     *       description="Fields to return separate by comas: title,id",
     *       required=false,
     *       type="string",
     *       paramType="query"
     *     ),
     *     @SWG\Parameter(
     *       name="limit",
     *       description="Number of object to return (max 100, default 25)",
     *       required=false,
     *       type="integer",
     *       format="int64",
     *       paramType="query",
     *       minimum="1"
     *     ),
     *     @SWG\Parameter(
     *       name="limitstart",
     *       description="Start of the return (default 0)",
     *       required=false,
     *       type="integer",
     *       format="int64",
     *       paramType="query",
     *       minimum="0"
     *     ),
     *     @SWG\Parameter(
     *       name="order",
     *       description="ORDER by this field separete by comas. Add + / - after field for set ASC / DESC: type+,name-",
     *       required=false,
     *       paramType="query",
     *       type="string"
     *     ),
     *  
     *     @SWG\ResponseMessage(code=403, message="Invalid API Key")
     *   )
     * )
     */
    public function __construct($app, $keyid = null)                       
    {
        //Manual binding filed we would like to expose with the API
        $fields =  array(	'id', 
				'title', 
				'alias', 
				'published', 
				'access', 
				'language', 
				'checked_out', 
				'checked_out_time', 
				'created_time', 
				'created_user_id', 
				'lft',
				'rgt', 
				'level', 
				'path');
        
        parent::__construct($app, $fields, $keyid);
       
        \JTable::addIncludePath(JPATH_SITE.'/administrator/components/com_tags/tables');
        $this->JTable = \JTable::getInstance('Tag', 'TagsTable');
        $this->table = "#__tags";
        $this->primaryKey = 'id';
        $this->order = 'id';
        
        //we can also use the model of the component. depends of the case and if the model is clean
       
        
    }

    /**
     * @SWG\Api(
     *   path="/tags/{id}",
     *   @SWG\Operation(
     *     method="GET",
     *     summary="Find tag by ID",
     *     notes="Returns a tag based on ID",
     *     type="Tag",
     *     nickname="getTagById",
     *     @SWG\Parameter(
     *       name="id",
     *       description="ID of tag that needs to be fetched",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="path",
     *       minimum="1"
     *     ),
     *     @SWG\Parameter(
     *       name="fields",
     *       description="Fields to return separate by comas: name,id",
     *       required=false,
     *       type="string",
     *       paramType="query"
     *     ),
     * 
     *     @SWG\ResponseMessage(code=400, message="Invalid ID"),
     *     @SWG\ResponseMessage(code=403, message="Invalid API Key")
     *   )
     * )
     */
    public function get()
    {
        parent::get();
    }

    /**
     * @SWG\Api(
     *   path="/tags",
     *   @SWG\Operation(
     *     method="POST",
     *     summary="Create a tag",
     *     notes="Create a tag",
     *     type="Tag",
     *     nickname="CreateTags",
     *     @SWG\Parameter(
     *       name="body",
     *       description="JSON object Tag",
     *       required=true,
     *       type="Tag",
     *       paramType="body"
     *     ),
     *     @SWG\ResponseMessage(code=201, message="Saved successfully"),
     *     @SWG\ResponseMessage(code=400, message="Invalid data"),
     *     @SWG\ResponseMessage(code=403, message="Invalid API Key"),
     *     @SWG\ResponseMessage(code=404, message="Not saved")
     *   )
     * )
     */
    public function post()
    {
        parent::post();
    }

    /**
     * @SWG\Api(
     *   path="/tags/{id}",
     *   @SWG\Operation(
     *     method="PUT",
     *     summary="Update a tag",
     *     notes="Update a tag",
     *     type="Tag",
     *     nickname="updateTagId",
     *     @SWG\Parameter(
     *       name="id",
     *       description="ID of tag",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="path",
     *       minimum="1"
     *     ),  
     *     @SWG\Parameter(
     *       name="body",
     *       description="JSON object of the updated tag",
     *       required=true,
     *       type="Tag",
     *       paramType="body"
     *     ),  
     *     @SWG\ResponseMessage(code=200, message="Updated successfully"),
     *     @SWG\ResponseMessage(code=400, message="Invalid data"),
     *     @SWG\ResponseMessage(code=403, message="Invalid API Key"),
     *     @SWG\ResponseMessage(code=404, message="Invalid ID")
     *   )
     * )
     */
    public function put()
    {
        parent::put();
    }

    /**
     * @SWG\Api(
     *   path="/tags/{id}",
     *   @SWG\Operation(
     *     method="DELETE",
     *     summary="Delete a specific tag",
     *     notes="Delete a specific tag",
     *     type="string",
     *     nickname="deleteTagById",
     *     @SWG\Parameter(
     *       name="id",
     *       description="ID of tag that needs to be deleted",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="path",
     *       minimum="1"
     *     ),
     *     @SWG\ResponseMessage(code=200, message="Tag correctly deleted"),
     *     @SWG\ResponseMessage(code=403, message="Invalid API Key"),
     *     @SWG\ResponseMessage(code=404, message="Invalid ID")
     *   )
     * )
     */
    public function delete()
    {
        parent::delete();
    }
}