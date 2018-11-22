<?php
require_once 'core.php';
$dbs = Tini::readIni(CONFPATH.'database.ini');
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="source/css/main.css"/>
</head>
<body>
	<ul>
		<?php foreach($dbs as $name => $db):?>
		<?php if(is_array($db)):?>
		<li style="color:<?php if($dbs['default'] == $name)echo 'blue';?>;"><a target="form" href="form.php?db=<?php echo $name;?>"><?php echo $name;?></a></li>
		<?php endif?>
		<?php endforeach?>
	</ul>
</body>
</html>
