<!DOCTYPE Frameset DTD PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>sqlyog</title>
</head>
<frameset cols="25%,*" border="1" >
	<frame src="index.php?ctrl=connect/table&name=<?php echo $name?>" name="tables_<?php echo $name?>" />
	<frameset rows="40%,*" border="1" >
		<frame src="index.php?ctrl=connect/query&name=<?php echo $name?>" name="query_<?php echo $name?>" />
		<frame src="index.php?ctrl=connect/result&name=<?php echo $name?>" name="result_<?php echo $name?>" frameborder="0" />
	</frameset>
</frameset>
</html>