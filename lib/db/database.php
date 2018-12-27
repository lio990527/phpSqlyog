<?php

class Database
{

	/**
	 * @var mysqli
	 */
	private $link = NULL;

	/**
	 * @var array
	 */
	private $ssl = NULL;
	
	/**
	 * @var int
	 */
	private $errno;

	/**
	 * @var string
	 */
	private $error = '';

	public function __construct(){
		
	}
	
	public function connect($host, $port = 3306, $user = 'root', $pass = '', $default = '', $socket = null)
	{
		$this->link = mysqli_init();
		$this->link->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
		
		if (! empty($this->ssl)) {
			$this->link->ssl_set($this->ssl['key'], $this->ssl['cert'], $this->ssl['ca'], $this->ssl['capath'], $this->ssl['cipher']);
		}
		try {
			if (! @mysqli_real_connect($this->link, $host, $user, $pass, $default, $port, $socket)) {
				$this->errno = $this->link->connect_errno;
				$this->error = $this->link->connect_error;
			}
		} catch (Exception $e) {
			$this->errno = $e->getMessage();
			$this->error = $e->getCode();
		}
		
		return $this->link;
	}

	public function error()
	{
		return empty($this->error) ? [] : array(
			'error' => $this->error,
			'errno' => $this->errno
		);
	}
	
	/**
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value){
		$this->$name = $value;
	}
	
	/**
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name){
		return $this->$name;
	}
}