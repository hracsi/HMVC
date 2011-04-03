<?php

/**
 * Sql
 * 
 * Handling the SQL operations.
 * 
 * @copyright     Copyright 2010, Hracsi's MVC Project http://hracsi.net
 * @package       hmvc
 * @subpackage    hmvc.core.model.sql
 * @since         hmvc (tm) v. 0.1.0.0
 * @version       hmvc (tm) v. 0.8.4.1
 * 
 */
 
class Sql
{
	protected 
		$_dsn,
		$_user,
		$_password,
        $_charset,
		$_dbh = null,

		$_connected,   /** bool If the source is connected. **/
        $_table,       /** string The name of the table. **/
		$_query,       /** string The SQL Statement. **/
		$_result,      /** Object_item The result as the object's resource. '**/
		$_limit;

/**
 * Constructor
 * 
 * Checks if the source is connected if it is then it reconnects if not then set all variables and connects  
 * 
 * @return boolean True if the source is connected, else false
 */
 
    public function __construct()
    {
        if ( $this->isConnected() ) {
            $this->reconnect();
            return $this->isConnected();
        }
        $this->clear();
        $this->connect();
        return $this->isConnected();
    }

/**
 * SQL::connect()
 * 
 * @param string $dsn The dsn link for sql connection.
 * @param string $user SQL user.
 * @param string $password SQL password.
 * @param string $charset The default charset.
 * @return boolean True if the database is connected, else false.
 */
     
    public function connect($dsn = null , $user = null, $password = null, $charset = null)
	{
        if ( !$this->isConnected() ) {
            if ( (!isset($dsn) or !isset($user) or !isset($password) or !isset($charset)) and  (isset($this->_dsn) and isset($this->_user) and isset($this->_password) and isset($this->_charset)) ) {
                $dsn        = $this->makeDSN(SQL_ENGINE,DB_NAME,HOST,CHARSET);
                $user       = $this->_user;
                $password   = $this->_password;
                $charset    = $this->_charset;
    		}
            if ( !isset($dsn) or !isset($user) or !isset($password) ) {
                $dsn        = $this->makeDSN(SQL_ENGINE,DB_NAME,HOST,CHARSET);
                $user       = DB_USER;
                $password   = DB_PASSWORD;
                $charset    = CHARSET;
    		}
          
            $this->_dbh = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '" . $charset . "'"));
      		$error = $this->_dbh->errorInfo();
            /** ERROR LOGGING/ERROR CATCHING CODE HERE **/
    		if ( $error[0] != 00000 ) {
    		  echo '<p>DATABASE CONNECTION ERROR:</p>';
    		  print_r($error);
              $this->_connected = false;  
    		  return false;
    		} else {
                $this->_dsn 		= $dsn;
    			$this->_user 		= $user;
    			$this->_password	= $password;
                $this->_charset     = $charset;
                $this->_connected   = true;
    			return true;
    		}            
        } else {
            return true;
        }
	}
    
/** Disconnects from database **/
    
    public function disconnect()
    {
		$this->_dsn = null;
		$this->_user = null;
		$this->_password = null;
		$this->_dbh = null;
        $this->clear();
        return $this;
    }
    
/**
 * Reconnects to database server with optional new settings
 *
 * @return boolean True on success, false on failure
 *
 */    
    public function reconnect()
    {
        if ( $this->isConnected() ) {
            $this->disconnect();
        }
        $this->clear();
        $this->connect();    
    	return $this->isConnected();
    }

/** Clear All Variables **/

    public function clear() 
    {
        $this->_table  = null;
		$this->_query = null;
		$this->_result = null;
		$this->_limit = null;
        return $this;
    }
    
/**
 * Checks if the source is connected to the database.
 *
 * @return boolean True if the database is connected, else false
 */
 
    public function isConnected()
    {
    	return $this->_connected;
    }
    
/**
 * SQL::makeDSN()
 * 
 * @param string $sqlEngine the type of the sql engine
 * @param string $db the database name
 * @param string $host the server's IP adress
 * @param string $charset the default charset
 * @return string Database source name for PDO::__construct()
 */
     
    public function makeDSN($sqlEngine = 'mysql', $db, $host = '127.0.0.1', $charset = 'UTF8')
    {
        return $sqlEngine . ':dbname=' . $db . ';host=' . $host . ';charset=' . $charset . ';';
    }
    
/**
 * SQL::table()
 * Setting the $this->_table for query
 * 
 * @param string $table name of the table 
 * @return Object $this
 */
     
    public function table($table)
    {
        $this->_table = $table;
        return $this;
    }

    public function test($a = '')
    {
        echo 'bent vagy';
    }
	
/**
 * SQL::prepare()
 * 
 * @param string $what if not all the data is required from the table
 * @return Object $this
 */
    public function prepare($what = "*")
	{
		$this->_query = "SELECT " . $what . " FROM `" . $this->_table ."`";
		return $this;
	}
	
	public function where($field, $value = null)
	{
        if ( !is_array($field) ) {
            $this->_query = $this->_query . " WHERE `" . $field . "`='" . $value . "'";
            return $this;
        }        
        
        $this->_query = $this->_query . " WHERE ";
        $i = 1;
        foreach($field as $field => $value) {
            if ( $i == 1 ) {
                $this->_query = $this->_query . "`" . $field . "`='" . $value . "'";
            }
            $this->_query = $this->_query . " AND `" . $field . "`='" . $value . "'";
            $i++; 
		}
        return $this;
	}
	
	public function setLimit($how)
	{
		$this->_query = $this->_query . " LIMIT " . $how;
		return $this;
	}
	
	public function orderBy($field, $type = 'ASC')
	{
        $this->_query = $this->_query . " ORDER BY `" . $field . "` " . $type;
		return $this;
	}
	
	public function custom($query)
	{
		$this->_query = $query;
		return $this;
	}
	
	public function execute()
	{
        if( !$this->_connected ) {
			$this->connect();
		}
		
		if ( substr_count(strtoupper($this->_query),'SELECT') > 0 ) {
            //echo '<br /><i>A jelnlegi SQL query: ' . $this->_query . '</i><br />';
			$this->_result = $this->_dbh->query($this->_query) or die ('error1' . print_r($this->_dbh->errorInfo()));
		} else {
			//echo 'q: ' . $this->_query;
            $this->_result = $this->_dbh->query($this->_query, PDO::FETCH_ASSOC) or die ('error2' . print_r($this->_dbh->errorInfo()));
		}
        //counting queries
        global $numberOfQueries;
        $numberOfQueries++;
		return $this;
	}
	
	public function countRows()
	{
		if( $this->_result ) {
			return $this->_result->rowCount();
		} else {
			return false;
		}
	}
	
	public function fetchAll()
	{
		return $this->_result->fetchAll();
	}
	
	public function next()
	{
		return $this->_result->fetch(PDO::FETCH_ASSOC);
	}

/**
 * SQL::describe()
 * 
 * Changing the query to DESCRIBE `table`.
 * 
 * @param string $table The name of the SQL table.
 * @return Object $this.
 */

    public function describe($table = '')
    {
        if( $table == '' ) {
            $table = $this->_table;
        }
        
        $this->_query = "DESCRIBE `" . $table . "`;";
        return $this;
    }
    
/**
 * Sql::saveDataBase()
 * 
 * Saving database into file.
 * 
 * @return void
 */
    public function saveDataBase(){
        $backupFile = ROOT . DS . 'db' . DS . DB_NAME . date('-Y.m.d.') . '.sql';
        $command = 'mysqldump --opt -h' . DB_HOST . ' -u' . DB_USER . ' -p' . DB_PASSWORD . ' ' . DB_NAME . ' > ' . $backupFile;
        system($command);    
    }
    
    public function __destruct()
    {
        //echo "<br />Vége a dalnak!" . $this->_query ."<br />";
    }

}