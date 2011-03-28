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

	public function __construct($model = null)
	{
		$this->connect();
        $this->_model = Inflector::makeModelName(get_class($this));
		$this->_table = Inflector::makeSqlTableName($this->_model);
        $this->data   = '';
        $this->fields = array();
        $this->key    = '';
	}

    
}