<?php

/**
 * Model
 * 
 * Giving the required paramaters to the SQL engine.
 *  
 * 
 * @copyright     Copyright 2010, Hracsi's MVC Project http://hracsi.net
 * @package       hmvc
 * @subpackage    hmvc.core
 * @since         hmvc (tm) v. 0.1.0.0
 * @version       hmvc (tm) v. 0.7.9.8 beta
 * 
 */
 
class Model extends SqlAaom
{
    protected $_model;
	
	public function __construct($model = null)
	{
        $this->_model = Inflector::makeModelName(get_class($this));
		$this->_table = Inflector::makeSqlTableName($this->_model);
        $this->data   = '';
        $this->fields = array();
        $this->key    = '';
	}
    
    /**
     * @todo PUT IT TO CRUD GENERATIONG CLASS 
    **/
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
    
    /**
     * @todo PUT IT OUT AFTER FINISHING THE TEST 
    **/
    public function test()
    {
        echo '<br />' . $this->makingSelect($this->describe()->execute()->fetchAll(),$this->_table) . '<br />';
        echo $this->makingFrom($this->getConnections())  . '<br />';;
        echo $this->makingConnections($this->getConnections());
    }

}