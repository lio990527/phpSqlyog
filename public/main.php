<!DOCTYPE Frameset DTD PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>sqlyog</title>
</head>
<frameset cols="25%,*" border="1" >
	<frame src="tables.php?name=<?php echo $_GET['name']?>&db=<?php echo $_GET['db']?>" name="tables_<?php echo $_GET['name']?>" />
	<frameset rows="40%,*" border="1" >
		<frame src="query.php?name=<?php echo $_GET['name']?>&db=<?php echo $_GET['db']?>" name="query_<?php echo $_GET['name']?>" />
		<frame src="result.php?name=<?php echo $_GET['name']?>&db=<?php echo $_GET['db']?>" name="result_<?php echo $_GET['name']?>" frameborder="0" />
	</frameset>
</frameset>
</html>