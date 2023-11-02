<?php
//code made by Alexandr
//created at 31.10.2023
//updated at 31.10.2023
/**
 * create class for work with tables
 */

class db
{
	public $dbhost='localhost';
	public $dbusername='root';
	public $dbpassword='';
	public $dbname='crud';
	function __construct(){
		$this->mysqli = new mysqli($this->dbhost, $this->dbusername, $this->dbpassword,$this->dbname);
	}
	/**
	* function for Select query
	*/
	public function Select($query){
		$makequery=$this->mysqli->query($query);
		$resultarray=$makequery->fetch_all(MYSQLI_ASSOC);
		return $resultarray;
	}
	/**
	* function for Update/Delete/Insert query
	*/
	public function atherActions($query){
		$this->mysqli->query($query);
	}
}
