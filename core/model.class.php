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
        $query = 'SELECT ' . $fields . 'FROM ' . $this->_table . ' WHERE ' . $condition . ' ' . $join . $goupBy . $orderBy . $having;
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
    
    public function getTableNameFromData($str)
    {
        return strtolower(substr($str, 0, strpos($str, '.')));
    }
    
    public function getFieldNameFromData($str)
    {
        return strtolower(substr($str,strpos($str, '.')+1));
    }
}