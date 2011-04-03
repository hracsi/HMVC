<?php

/**
 * SqlAaom
 * 
 * SQL's Advanced Automatic Operations Manager
 *  
 * 
 * @copyright     Copyright 2010, Hracsi's MVC Project http://hracsi.net
 * @package       hmvc
 * @subpackage    hmvc.core
 * @since         hmvc (tm) v. 0.1.0.0
 * @version       hmvc (tm) v. 0.7.9.8 beta
 * 
 */
 
class SqlAaom extends Sql
{
    public $connectorTable = false;
    public $connections = array();
    private $data,$fields,$key;
    protected $type,$select,$distinct,$from,$where,$orderBy,$groupBy,$having,$limit;

	public function __construct($model = null)
	{
		$this->connect();
        $this->data   = '';
        $this->fields = array();
        $this->key    = '';
	}

/**
 * SqlAaom::getConnections()
 *  
 * @return array the connections that are set in the Models
 */
    public function getConnections()
    {
        return $this->connections;
    }

/**
 * SqlAaom::describeTable()
 * 
 * @param string $table The name of the SQL table.
 * @return array All the information about the table that the DESCRIBE `table` can give.
 */
    public function describeTable($table = '')
    {
        return $this->describe($table)->execute()->fetchAll(); 
    }
    
    public function getTablePrimaryKeyName($describe = '', $table = '')
    {
        if ( !$table ) {
            $table = $this->_table;
        }
        if ( !$describe ) {
            $describe = self::describeTable($table);
        }
        
        foreach($describe as $fields) {
            foreach($fields as $property => $value){
                if ( lowCase($property) == 'field' ) {
                    $fieldName = $value;
                }
                if ( lowCase($property) == 'key' and lowCase($value) == 'pri' ) {
                    return $fieldName;
                }
            }
        }
    }
    
    
/**
 * SqlAaom::makingFieldsList()
 * 
 * @param array $describe An array that desicribes the structure of the table.
 * @param string $table The name of the table.
 * @return string List of fields in the table.
 * 
 */
    protected function makingFieldsList($describe = null, $table = null)
    {
        if ( !$table ) {
            $table = $this->_table;
        }
        if ( !$describe ) {
            $describe = self::describeTable($table);
        }

        $tableFields = array();
        foreach($describe as $fields) {
            foreach($fields as $property => $value){
                if ( lowCase($property) == 'field' ) {
                    array_push($tableFields, $table . '.' . $value);
                }
            }
        }
    
        $select = '';
        foreach($tableFields as $tableField){
            $select.= $tableField . ', ';
        }
        
        return substr($select,0,strlen($select)-2);
    }
    
/**
 * SqlAaom::makingFrom()
 * 
 * Making the list of the names of tables for FROM.
 * 
 * @param array $array The $connections of the tables.
 * @return srtring List of tables separted by comma.
 */
    protected function makingFrom($array = null)
    {
        if ( !$array ) {
            $array = self::getConnections();
        }
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
        return substr($from,0,strlen($from)-2);
    }
    
/**
 * SqlAaom::makingWhere()
 * 
 * Putting together extra conditions if they exist and connection tables.
 * 
 * @param array $conditions The extra conditions for the selection.
 * @return string The final WHERE part.
 * 
 */
    public function makingWhere($conditions = null, $connectTables = 1){
        if ( is_array($conditions) ) {
            foreach($conditions as $field => $value){
                $c.= $this->_table . '.' . $field . ' = ' . $value . ' AND ';
            }
            $c = substr($c,0,strlen($c)-5);
        }
        if ( $connectTables ) {
            if ( self::makingConnections($this->getConnections()) ){
                if ( $c ) {
                    $c.= ' AND ';
                }
                $c.= self::makingConnections($this->getConnections());
            }
        }
        return $c;
    }
    
/**
 * SqlAaom::makingConnections()
 * 
 * @param array $array The $connections of the tables.
 * @return string The extra conditions for WHERE.
 */
    protected function makingConnections($array)
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
    
    public function setQuery($type, $conditions = null, $orderBy = null, $groupBy = null, $having = null, $limit = null)
    {
        $type = lowCase($type);
        switch ($type){ 
            case 'create':
                $table = $this->_table;
                $fields = self::makingFieldsList();
                $values = $this->data;
                $data = compact('table','fields','values');
            break;
            case 'read':
                $fields = self::makingFieldsList();
                $table   = self::makingFrom();
                if ( self::makingWhere($field,$value) ) {
                    $where = ' WHERE ' . self::makingWhere($conditions);
                } else {
                    $where = '';
                }
                $data = compact('fields','table','where');
            break;
            case 'update':
            break;
            case 'delete':
                $table = $this->_table;
                $where = ' WHERE ' . self::makingWhere($conditions, 0);
                $data  = compact('table','where');
            break;
        }

        $this->_query = self::renderSqlStatement($type, $data);
        return $this;
    }
    
/**
 * SqlAaom::renderSqlStatement()
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
                if ( $this->distinct ) {
                    $distinct = 'DISTINCT ';
                }
                return 'SELECT ' . $distinct . $fields . ' FROM ' . $table . $where . $groupBy . $orderBy . $having . $limit;
            break;
            case 'INSERT':
                return 'INSERT INTO ' . $table . ' ' . $fields . ' VALUES (' . $values . ')'; 
            break;
            case 'UPDATE':
                return 'UPDATE ' . $table . ' SET ' . $values . $where;
            break;
            case 'DELETE':
                return 'DELETE FROM ' . $table . ' '. $where;
            break;
            default:
                /**
                 * @todo Error logging here.
                **/
        }
    }
    
/**
 * SqlAaom::getTableNameFromData()
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
 * SqlAaom::getFieldNameFromData()
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