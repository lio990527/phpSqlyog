<?php 
require_once 'core.php';
$dbs = Tini::readIni(CONFPATH.'database.ini');
$dbname = empty($_REQUEST['db']) ? $dbs['default'] : $_REQUEST['db'];
$db = array_key_exists($dbname, $dbs) ? $dbs[$dbname] : array();
$db['name'] = $dbname;

?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="source/css/main.css"/>
</head>
<body>
	<form action="connect.php" target="_parent" method="post">
		<input type="hidden" name="origin_name" value="<?php echo $db['name']?>"/>
		<label>name:</label>
		<input name="name" value="<?php if(isset($db['name'])) echo $db['name'];?>"/><br/>
		<label>host:</label>
		<input name="host" value="<?php if(isset($db['host'])) echo $db['host'];?>"/><br/>
		<label>port:</label>
		<input name="port" value="<?php echo (isset($db['port'])) ? $db['port'] : 3306;?>"/><br/>
		<label>username:</label>
		<input name="user" value="<?php if(isset($db['user'])) echo $db['user'];?>"/><br/>
		<label>password:</label>
		<input name="pass" value="<?php if(isset($db['pass'])) echo $db['pass'];?>"/><br/>
		<label>database:</label>
		<input name="default" value="<?php if(isset($db['default'])) echo $db['default'];?>"/><br/>
		<button>save</button> &nbsp;
		<button>connect</button>
	</form>
</body>
</html>
