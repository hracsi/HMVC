<?php

/**
 * Giving the required paramaters to the SQL engine
 *  
 * 
 * @copyright     Copyright 2010, Hracsi's MVC Project http://hracsi.net
 * @package       hmvc
 * @subpackage    hmvc.core
 * @since         hmvc (tm) v. 0.1.0.0
 * @version       hmvc (tm) v. 0.7.9.8 beta
 * 
 */
 
class Model extends SQL
{
	public $connectorTable = false;
    public $connections = array();
    protected $_model;
    private $data,$fields,$key;
	
	public function __construct($model = null)
	{
		$this->connect();
        $this->_model = Inflector::makeModelName(get_class($this));
		$this->_table = Inflector::makeSqlTableName($this->_model);
        $this->data   = '';
        $this->fields = array();
        $this->key    = '';
	}
    
    public function getConnections()
    {
        return $this->connections;
    }
    
    public function read()
    {
        // feldolgozó tömb ami tartalmazza a megfelelő elemeket $this->data ;
        $this->data = $this->describe();
        $this->key = '';
        
        foreach($this->data as $fields) {
            foreach($fields as $property => $value){
                $property = lowCase($property);
                if ( $property == 'field' ) {
                    $this->fields = array_push($this->fields, $value);
                    if ( lowCase($value) == 'id' ) {
                        $this->key = $value;
                    } else {
                        $name = $value;
                    }
                } elseif ( $property == 'type' ) {
                    $type = 'text';
                } elseif ( !$this->key and $property == 'key' ) {
                    $this->key = $fields['Field'];
                }
            }
        }
        $query = 'SELECT ' . $fields . 'FROM ' . $this->_table . ' WHERE ' . $condition . ' ' . $join . $groupBy . $orderBy . $having;
    }
    
    public function test()
    {
        echo '<br />' . $this->makingSelect($this->describe()->execute()->fetchAll(),$this->_table) . '<br />';
        echo $this->makingFrom($this->getConnections())  . '<br />';;
        echo $this->makingWhere($this->getConnections());
    }
    
/**
 * Model::makingSelect()
 * 
 * @param array $describe
 * @param string $table
 * @param bool $distinct
 * @return string list of fields in the table
 */
     
    private function makingSelect($describe, $table, $distinct = true)
    {
        if ( $distinct ) {
            $dist = 'DISTINCT '; 
        }
        $tableFields = array();
        foreach($describe as $fields) {
            foreach($fields as $property => $value){
                $property = lowCase($property);
                if ( $property == 'field' ) {
                    array_push($tableFields, $table . '.' . $value);
                }
            }
        }
    
        $select = '';
        foreach($tableFields as $tableField){
            $select.= $tableField . ', ';
        }
        
        return 'SELECT ' . $dist . substr($select,0,strlen($select)-2);
    }
    
/**
 * Model::makingFrom()
 * 
 * @param array $array the $connections of the tables
 * @return srtring ex.: 'FROM users, posts ...'
 */
 
    private function makingFrom($array)
    {
        $tables = array();
        foreach($array as $key => $value){
            if ( !in_array(self::getTableNameFromData($key),$tables) ) {
                array_push($tables,self::getTableNameFromData($key));            
            }
            if ( !in_array(self::getTableNameFromData($value),$tables) ) {
                array_push($tables,self::getTableNameFromData($value));            
            }        
        }
    
        foreach($tables as $table){
            $table = Inflector::makeModelName($table);
            $t = new $table;
            $t = $t->getConnections();
            foreach($t as $key => $value){
                if ( !in_array(self::getTableNameFromData($key),$tables) ) {
                    array_push($tables,self::getTableNameFromData($key));            
                }
                if ( !in_array(self::getTableNameFromData($value),$tables) ) {
                    array_push($tables,self::getTableNameFromData($value));            
                }        
            }        
        }
        
        $from = '';
        foreach($tables as $table){
            $from .= $table . ', ';
        }
        return 'FROM ' . substr($from,0,strlen($from)-2);
    }
    
/**
 * Model::makingWhere()
 * 
 * @param array $array the $connections of the tables
 * @return string the extra conditions for WHERE
 */
 
    private function makingConnections($array)
    {
        $tables = array();
        foreach($array as $key => $value){
            if ( !in_array(self::getTableNameFromData($key),$tables) ) {
                array_push($tables,self::getTableNameFromData($key));            
            }
            if ( !in_array(self::getTableNameFromData($value),$tables) ) {
                array_push($tables,self::getTableNameFromData($value));            
            }        
        }
        
        $extTables = $tables;
        foreach($tables as $table){
            $t = Inflector::makeModelName($table);
            $t = new $t;
            $t = $t->getConnections();
            foreach($t as $key => $value){
                if ( !in_array(self::getTableNameFromData($key),$extTables) ) {
                    array_push($extTables,self::getTableNameFromData($key));            
                }
                if ( !in_array(self::getTableNameFromData($value),$extTables) ) {
                    array_push($extTables,self::getTableNameFromData($value));            
                }        
            }        
        }
        
        $where = '';
        foreach($extTables as $table){
            $t = Inflector::makeModelName($table);
            $t = new $t;
            $t = $t->getConnections();
            foreach($t as $key => $value){
                $where.= $key . ' = ' . $value . ' AND ';
            }
        }
        return substr($where,0,strlen($where)-5);    
    }
    
    private function makingConnection($array)
    {
        /*
        SELECT 
            posts.id, posts.title, posts.text, posts.date, posts.cat_id, posts.user_id, categories.name AS CategoryName, tags.name AS TagName, users.name as UserName, user_groups.name as UserGroupName
        FROM 
            posts, categories, tag_connections, tags, users, user_groups
        WHERE 
            posts.cat_id = categories.id
        AND posts.user_id = users.id
        AND users.user_group_id = user_groups.id
        AND tag_connections.post_id = posts.id
        AND tag_connections.tag_id = tags.id;
        
        Post:
        $connectorTable = false;
        $connections = array('posts.cat_id' => 'categories.id','posts.id' => 'tag_connections.post_id', 'posts.user_id' => 'users.id');
        
        TagConnect:
        $connectorTable = true;
        $connectedTables = array('Posts' => 'Tags');
        $connections = array();
        
        Tags:
        $connectorTable = false;
        $connections = array('tags.id' => 'tag_connections.tag_id');
        
        User:
        $connectorTable = false;
        $connections = array('user.user_group_id' => 'user_groups.id');
        
        SELECT 
            posts.id, posts.title, posts.text, posts.date, posts.cat_id, posts.user_id, 
        FROM
            posts, categories, tag_connections, users, 
        WHERE
            posts.cat_id = categories.id
        AND posts.user_id = users.id
        AND user.user_group_id = user_groups.id
        AND posts.id = tag_connections.post_id
        
        */
        $condition = '';
        foreach($array as $key => $value){
            $condition.= $key . ' = ' . $value . ' AND ';
        }
        echo strlen($condition)-4;
        $condition = substr($condition,0,strlen($condition)-4);
        
        
    }
    
    public function queryMaker($type, $fields, $conditions, $connections, $orderBy, $groupBy, $orderBy, $having)
    {
        //TYPE
        $type = upCase($type);
        if ( $type == 'SELECT' ) {
            //FIELDS
            $fs = '';
            foreach($fields as $field){
                $fs = $fs . $field . ',';
            }
            $fs = substr($fs, 0, -1); //removing the last comma of the of the sring
            
            //INNER JOIN - CONNECT TABLES
            $con = '';
            if ( $connections ) {
                foreach($connections as $connector => $connect){
                    $con = 'INNER JOIN ' . getTableNameFromData($connector) . ' ON ' . $connector . ' = ' . $connect . ' ';
                    
                }
            }
            
            /*
			if ($fields == null) {
				unset($fields, $values);
				$fields = array_keys($model->data);
				$values = array_values($model->data);
			}
            
            foreach($categories as $category){
                if ( in_array($category['id'],$leaves) ){
                    $plus = $plus . "cat_id = '" . $category['id'] . "' OR ";
                }
            }
            $plus = substr($plus,0,strlen($plus)-4);
            */
            //WHERE - CONDITION
            $cond = '';
            if ( $conditions ) {
                if ( $connections ) {
                    $having = 1;
                }
                foreach($conditions as $condition){
                    $con = $con . '';
                }
            }
            
        } elseif ( $type = 'UPDATE') {
            
        }
        
    }
    
/**
 * Model::renderSqlStatement()
 * 
 * @param string the type of the SQL statement
 * @param array all variables that needed to build the SQL statement
 * @return string SQL statement
 */
     
    public function renderSqlStatement($type, $data)
    {
        extract($data,EXTR_OVERWRITE);
        $type = upCase($type);
        switch ($type){ 
            case 'SELECT':
                return 'SELECT ' . $fields . ' FROM ' . $table . $joins . $conditions . $group . $order . $limit;
            break;
            case 'INSERT':
                return 'INSERT INTO ' . $table . ' ' . $fields . ' VALUES (' . $values . ')'; 
            break;
            case 'UPDATE':
                return 'UPDAE ' . $table . ' SET ' . $fields . $conditions;
            break;
            case 'DELETE':
                return '';
            break;
        }
    }
    
/**
 * Model::getTableNameFromData()
 * 
 * Getting the name of the table from this: table.field
 * 
 * @param string the table.field
 * @return string table
 */
     
    public function getTableNameFromData($str)
    {
        return strtolower(substr($str, 0, strpos($str, '.')));
    }
    
/**
 * Model::getFieldNameFromData()
 * 
 * Getting the name of the field from: table.field
 * 
 * @param string the table.field
 * @return string field
 */
     
    public function getFieldNameFromData($str)
    {
        return strtolower(substr($str,strpos($str, '.')+1));
    }
}