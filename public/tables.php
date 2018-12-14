<?php
require_once 'core.php';
$db = $_GET['db'];
$conn = Tmysql::factory($db);

$default = $conn->conf['default'];
$dbs = array();
if(empty($default)){
	$dbs = $conn->show_dbs();
}else{
	$tables = $conn->show_tables();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link type="text/css" rel="stylesheet" href="source/css/comm.css"/>
<script type="text/javascript">
// 	$(function(){
// 		$('.dbList').find('a').on('mousedown', function(){
// 			var db = $(this);
// 			db.next('a').click();
// 			var tables = $(this).parent().find('div.tableList');
// 			if(tables.css('display') != 'none'){
// 				tables.hide();
// 				return false;
// 			}
// 			$('div.tableList').hide();
// 			$.ajax({
// 			type : 'get',
// 				async: false,
// 				url : '/index.php?param=/dot/dotDb',
// 				data: 'type=tables&dbName='+this.title,
// 				dataType : 'html',
// 				success : function(info){
// 					tables.show().find('form').html(info);
// 				},
// 				error:function(){
// 					;
// 				}
// 			});
// 		});
// 	});

	function showData(dom){
		//var input = $(dom).parentsUntil('form').parent().find('input[type="hidden"]')[0];
		var frame = window.parent.document.getElementsByName('<%$dbName%>_result')[0];
		if(frame == undefined){
			return false;
		}
		var view = frame.contentDocument.getElementById('viewInfo');
		var tbl = $(dom).text();
		$.get("/ajax.php?dbName=<%$dbName%>&table="+tbl,function(data){
			$(view).html(data).show();
		});
		//input.value = 'SELECT * from '+$(dom).text()+' LIMIT 100;';
		//console.log($(window.parent));
		//input.form.submit();
	}

</script>

<style type="text/css">
	body{margin:0;padding:10px 20px;background:#eef1f8;}
	.tableList span.table{cursor:pointer;}
	.tableList table td{padding:2px;}
	.ico{width:12px;height:12px;display:inline-block;cursor:pointer;}
</style>
</head>
<body>
	<ul class="dbList" style="margin-left:-10px;list-style-type:none;font-size:12px;">
		<li>
			<span class="ico wingbtn">:</span>
			<a title="<?php echo $db?>"><?php echo $db?></a>
			<div class="tableList" style="display:;">
				<form action="result.php?db=<?php echo $db?>" method="post" target="result_<?php echo $db?>">
					<table border="0" cellpadding="0" cellspacing="0" style="margin-left:15px;">
						<?php foreach ($tables as $table):?>
						<tr>
							<td><span class="ico wingbtn">+</span></td>
							<td><span class="table" ondblclick="showData(this)"><?php echo $table['Tables_in_xyb_dev'];?></span></td>
						</tr>
						<?php endforeach;?>
					</table>
					<input name="sql" type="hidden"/>
				</form>
			</div>
		</li>
	</ul>
</body>
</html>