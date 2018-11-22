<?php 
class Tmysql{
	
	private static $conn = array();
	
	private static $table = '';
	
	/**
	 * @param string $name
	 * @return mysqli an object
	 */
	public static function connect($name){
		if(!array_key_exists($name, self::$conn)){
			$conf = self::get_db_conf($name);
			self::$conn[$name] = new mysqli($conf['host'], $conf['user'], $conf['pass'], $conf['default'], $conf['port']);
		}
		return self::$conn[$name];
	}
	
	public function insert($info){
		$sql = "INSERT INTO {$this->table} VALUES ()";
		$this->conn->multi_query($sql);
	}
	
	public function update($set, $where){
		
	}
	
	public function delete($where){
		
	}
	
	public function search($where, $clos = '*'){
		
	}
	
	public function info($where){
		
	}
	
	public function count($where){
		
	}
	
	public function __set($name, $value){
		$this->$name = $value;
	}
	
	public function query($sql){
		return $this->conn->query($sql);
	}
	
	public function result(){
		
	}
	
	private static function get_db_conf($name){
		$dbs = Tini::readIni(CONFPATH.'database.ini');
		array_key_exists($name, $dbs) OR die('wrong database name');
		return $dbs[$name];
	}
}
