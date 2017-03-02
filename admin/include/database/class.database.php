<?php

/*

Database class

*/

class database {
	
	// Set DB_URL
	function database($url = '') {
		$this->db_url = $url;
		// Connect to database
		$this->connect();
		// Check for database connection error
		if($this->is_error()) {
			die($this->get_error());
		}
	}
	
	// Connect to the database
	function connect() {
		$status = $this->db_handle = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
		if(mysql_error()) {
			$this->connected = false;
			$this->error = mysql_error();
		} else {
			if(!mysql_select_db(DB_NAME)) {
				$this->connected = false;
				$this->error = mysql_error();
			} else {
				$this->connected = true;
			}
		}
		return $this->connected;
	}
	
	// Disconnect from the database
	function disconnect() {
		if(isset($this->Database)) {
			mysql_close();
			return true;
		} else {
			return false;
		}
	}
	
	// Run a query
	function query($statement) {
		$mysql = new mysql();
		$mysql->query($statement);
		if($mysql->error()) {
			$this->set_error($mysql->error());
			return null;
		} else {
			return $mysql;
		}
	}
	
	// Gets the first column of the first row
	function get_one($statement) {
		$fetch_row = mysql_fetch_row(mysql_query($statement));
		$result = $fetch_row[0];
		if(mysql_error()) {
			$this->set_error(mysql_error());
			return null;
		} else {
			return $result;
		}
	}
	
	// Set the DB error
	function set_error($message = null) {
		global $TABLE_DOES_NOT_EXIST, $TABLE_UNKNOWN;
		$this->error = $message;
		if(strpos($message, 'no such table')) {
			$this->error_type = $TABLE_DOES_NOT_EXIST;
		} else {
			$this->error_type = $TABLE_UNKNOWN;
		}
	}
	
	// Return true if there was an error
	function is_error() {
		return (!empty($this->error)) ? true : false;
	}
	
	// Return the error
	function get_error() {
		return $this->error;
	}
	
}

class mysql {

	// Run a query
	function query($statement) {
		return $this->result = mysql_query($statement);
		$this->error = mysql_error();
	}
	
	// Get the ID generated from the previous INSERT operation
	function insertID() {
		return mysql_insert_id();
	}

	// Fetch num rows
	function numRows() {
		return mysql_num_rows($this->result);
	}
	
	// Fetch row
	function fetchRow() {
		return mysql_fetch_array($this->result);
	}
	
	// Get error
	function error() {
		if(isset($this->error)) {
			return $this->error;
		} else {
			return null;
		}
	}

}

?>