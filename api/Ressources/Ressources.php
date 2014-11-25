<?php
/**
 * @version     Ressources/Ressources.php 2014-11-14 11:30:00 UTC pav
 */
namespace Ressources;
class Ressources
{
    public $app;
    public $fields;
    public $belongField;
    public $queryFields;
    public $primaryKey;
    public $keyid;
    public $table;
    private $conditions = array();
    public $order;
    public $JTable;
    public $filerFields;
    public $timeField = 0;

    public function __construct($app, $fields, $keyid, $filerFields = false)
    {
        $this->app = $app;
        $this->fields = $fields;
        $this->keyid = $keyid;
        $this->filerFields = $filerFields;

        //diseable the selection of fields
        if ($filerFields)
        {
            $this->queryFields = $this->fields;
        }
        else
        {
            $this->setQueryFields();
        }
    }

    /**
     * Manage the options route
     * single object
     * 
     * @throws \Exception
     */
    public function options()
    {
       $this->response('ok', 200);
    }
    
    /**
     * Manage the get route and choose if it's a call for a collection or a
     * single object
     * 
     * @throws \Exception
     */
    public function get()
    {

        //Return a single object
        if ($this->keyid)
        {
            $this->response(
                    $this->getObject()
            );
        }

        //Return a collection of object
        if (!$this->keyid)
        {
            $this->response(
                    $this->getObjects()
            );
        }
    }

    /**
     * Insert an object in the database
     * 
     * @throws \Exception
     */
    public function post($data = null)
    {
        if ( ! $data)
        {
            //should be replaced by jinput if possible
            $data = json_decode($this->app->request->getBody(), true);
        }
        
        if (json_last_error() !== JSON_ERROR_NONE)
        {
            throw new \Exception('Invalid data (check that it is a correct JSON format', 400);
        }

        if ($this->belongField)
        {
            $data[$this->belongField] = $this->app->user->id;
        }

        $this->saveData($data);
        $this->response($this->getObject(), 201);
    }

    /**
     * Delete a specific object in the database
     * @throws \Exception
     */
    public function delete()
    {
        $this->getObject();
        try
        {
            $this->JTable->delete($this->keyid);
        }
        catch (RuntimeException $e)
        {
            throw new \Exception($e->getMessage(), 500);
        }
    }

    /**
     * Update an object in the database
     * 
     * @throws \Exception
     */
    public function put($data = null)
    {

        if ( ! $data)
        {
            //should be replaced by jinput if possible
            $data = json_decode($this->app->request->getBody(), true);
        }

        if (json_last_error() !== JSON_ERROR_NONE)
        {
            throw new \Exception('Invalid data (check that it is a correct JSON format', 400);
        }
        $data[$this->primaryKey] = $this->keyid;

        $this->saveData($data);
        $this->response($this->getObject(), 200);
    }

    /**
     * Get a specific object in the database
     * 
     * @return an object
     * @throws \Exception
     */
    function getObject()
    {
        $db = $this->app->_db;
        $query = $db->getQuery(true);

        $query->select($db->quoteName($this->queryFields));
        $query->from($db->quoteName($this->table));
        $query->where($db->quoteName($this->primaryKey) . ' = ' . $this->keyid);

        $query->where($this->conditions);

        try
        {
            $db->setQuery($query);
            $result = $db->loadObject();
        }
        catch (RuntimeException $e)
        {
            throw new \Exception($e->getMessage(), 500);
        }

        if ( ! $result)
        {
            throw new \Exception('Invalid id', 400);
        }

        return $result;
    }

    /**
     * Build the query
     * 
     * @return \JDatabaseQuery
     */
    protected function buildQuery()
    {
        $db = $this->app->_db;

        $query = $db->getQuery(true);
        $query->select($db->quoteName($this->queryFields));
        $query->from($db->quoteName($this->table));

        //manage order
        $query = $this->getOrder($query);

        //Filter the query
        $this->addFilters();


        if (count($this->conditions) > 0)
        {
            $query->where($this->conditions);
        }

        return $query;
    }

    /**
     * The function generate a list of object
     * 
     * @return \stdClass object 
     *      => "data" a lists of object
     *      => "total" the total number of objects
     * @throws \Exception
     */
    function getObjects()
    {
        $query = $this->buildQuery();

        $jinput = \JFactory::getApplication()->input;
        $limit = $jinput->get('limit', 25, 'int');
        $limitstart = $jinput->get('limitstart', 0, 'int');

        $db = $this->app->_db;
        try
        {
            $db->setQuery($query, $limitstart, $limit);
            $data = $db->loadObjectList();

            $db->setQuery($query);
            $total = count($db->loadObjectList());
        }
        catch (RuntimeException $e)
        {
            throw new \Exception($e->getMessage(), 500);
        }
        $result = new \stdClass();
        $result->data = $data;
        $result->total = $total;
        return $result;
    }

    /**
     * Generate the response
     * 
     * @param type $data
     * @param type $status
     */
    public function response($data, $status = 200)
    {
        $this->app->render($status, array(
            'msg' => $data,
        ));
    }

    /**
     * Add a condition to the query
     * @param type $condition
     */
    public function addCondition($condition)
    {
        $this->conditions[] = $condition;
    }

    /**
     * 
     * @todo this clears all conditions
     */
    public function emptyCondition()
    {
        $this->conditions[] = array();
    }

    /**
     * Calculate the query
     */
    private function addFilters()
    {
        $jinput = \JFactory::getApplication()->input;
        $db = $this->app->_db;

        foreach ($this->fields as $field)
        {
            $value = $jinput->get($field, null, 'string');
            $condition = 'LIKE';

            if ( ! $value)
            {
                continue;
            }
              
            if ($value[0] == '!')
            {
                $condition = 'NOT LIKE';
                $value = ltrim($value, '!');
            } 
            $this->addCondition($db->quoteName($field) . ' ' . $condition . ' ' . $db->quote($value));
        }
    }

    /**
     * Limit the number of fields returned by the call
     * 
     * @throws \Exception
     */
    private function setQueryFields()
    {
        $jinput = \JFactory::getApplication()->input;

        //filter the request fields
        $fieldlist = $jinput->get('fields', null, 'string');
        if ($fieldlist)
        {
            $fieldArray = explode(',', $fieldlist);
            $this->queryFields = array_intersect($fieldArray, $this->fields);
        }
        else
        {
            $this->queryFields = $this->fields;
        }

        // prepend table name to allow joins
        foreach ($this->queryFields as &$field)
        {
            $field = $this->table . "." . $field;
        }

        if (count($this->queryFields) == 0)
        {
            throw new \Exception('No fields with this name', 401);
        }
    }

    /**
     * Save a single record using the relevant JTable methods. This applies to 
     * both insert and update. After "store", $this->row contains the ID of the
     * record so we apply that to the current object
     * 
     * @param type $data
     * @throws \Exception
     */
    protected function saveData($data)
    {
        if ( ! $this->JTable->bind($data))
        {
            throw new \Exception($this->row->getError(), 404);
        }
        if ( ! $this->JTable->check())
        {
            throw new \Exception($this->row->getError(), 404);
        }
        if ( ! $this->JTable->store())
        {
            throw new \Exception($this->row->getError(), 404);
        }
        $this->keyid = $this->JTable->{$this->primaryKey};
    }

    /**
     * This take care of the order of the query
     * @param type $query
     * @return type
     */
    public function getOrder($query)
    {
        $jinput = \JFactory::getApplication()->input;
        $order = $jinput->get('order', $this->order, 'string');

        if ($order)
        {
            $replace = array("+", "-");
            $sqlOrders = array(" ASC", " DESC");

            $orderstring = str_replace($replace, $sqlOrders, $order);

            $query->order($orderstring);
        }

        return $query;
    }

    /**
     * Use this method to exit cleanly from any other unfinished method
     * 
     * @throws \Exception
     */
    public function notImplemented()
    {
        throw new \Exception('Not implemented', 404);
    }

}