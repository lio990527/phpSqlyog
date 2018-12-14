<?php 
class Tmysql{
	
	private static $self = null;
	
	/**
	 * 
	 * @var mysqli
	 */
	private $conn = null;
	
	
	private $conf = null;
	
	private static $table = '';
	
	
	private function __construct($name){
		$this->conf = self::get_db_conf($name);
		$this->conn = new mysqli($this->conf['host'], $this->conf['user'], $this->conf['pass'], $this->conf['default'], $this->conf['port']);
	}
	
	/**
	 * @param string $name
	 * @return Tmysql
	 */
	public static function factory($name){
		if(empty(self::$self)){
			self::$self = new Tmysql($name);
		}
		return self::$self;
	}
	
	public function show_dbs(){
		$result = $this->conn->query("SHOW databases");
		return $this->result_list($result);
// 		$result = $conn->query("SHOW FULL COLUMNS FROM {$table}");
// 		$result = $conn->query("SHOW FULL COLUMNS FROM {$table}");
// 		$result = $conn->query("SELECT * from information_schema.tables where table_schema='{$db}'");
	}
	
	public function show_tables(){
		$result = $this->conn->query("SHOW TABLES");
		return $this->result_list($result);
	}
	
	public function query($sql) {
		return $this->conn->query($sql);
	}
	
	/**
	 * 
	 * @param mysqli_result $result
	 * @return array
	 */
	public function result_array($result){
		return mysqli_fetch_assoc($result);
	}
	
	/**
	 *
	 * @param mysqli_result $result
	 * @return array
	 */
	public function result_list($result){
		$res = array();
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($res, $row);
		}
		return $res;
	}
	
	public function __set($name, $value){
		$this->$name = $value;
	}
	
	public function __get($name){
		if(property_exists($this, $name)){
			return $this->$name;
		}
		if(property_exists($this->conn, $name)){
			return $this->conn->$name;
		}
		return NULL;
	}
	
	public function __call($name, $args = array()){
		return call_user_func_array(array($this->conn, $name), $args);
	}
	
	private static function get_db_conf($name){
		$dbs = Tini::readIni(CONFPATH.'database.ini');
		array_key_exists($name, $dbs) OR die('wrong database name');
		return $dbs[$name];
	}
}
