<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link type="text/css" rel="stylesheet" href="source/css/comm.css"/>
<script type="text/javascript" src="source/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="source/js/comm.js"></script>
<script type="text/javascript">
	var name = '<?php echo $name?>';
	$(function(){
		$('.dbList').find('a').on('mousedown', function(){
			var db = $(this);
			var tables = $(this).parent().find('div.tableList');
			if(tables.css('display') != 'none'){
				tables.hide();
				return false;
			}
			$('div.tableList').hide();
			$.ajax({
				type : 'get',
				async: true,
				url : 'index.php?ctrl=connect/table',
				data: {name:name, db:$(db).text()},
				dataType : 'html',
				success : function(info){
					tables.show().html(info);
					showInfo(name, $(db).text());
				},
				error:function(){
					;
				}
			});
			
			var query = getFrameDom('query_'+name);
			query.forms['query'].db.value = $(db).text();
		});
	});

	function showData(dom){
		var result = getFrameDom('result_'+name);
		var db = $(dom).parents('li').find('a').text();
		var table = $(dom).text();
		$.ajax({
			type : 'get',
			async: false,
			url : 'index.php?ctrl=connect/data',
			data: {name:name, db:db, table:table},
			dataType : 'html',
			success : function(info){
				$(result).find('#viewTable').html(info);
				showInfo(name, db, table);
				if($(result).find('#viewTable').css('display') == 'none' && $(result).find('#viewInfo').css('display') == 'none'){
					$(result).find('li[title=Table]').trigger('click');
				}
			},
			error:function(){
				;
			}
		});
	}

	function showInfo(name, db, table){
		var result = getFrameDom('result_'+name);
		$.ajax({
			type : 'get',
			async: false,
			url : 'index.php?ctrl=connect/info',
			data: {name:name, db:db, table:table},
			dataType : 'html',
			success : function(info){
				$(result).find('#viewInfo').html(info);
			},
			error:function(){
				;
			}
		});
	}

</script>

<style type="text/css">
	body{margin:0;padding:10px 20px;background:#eef1f8;}
	.tableList span.table{cursor:pointer;}
	.tableList table td{padding:2px;}
	.ico{width:12px;height:12px;display:inline-block;cursor:pointer;}
	.dbList{margin-left:-10px;list-style-type:none;font-size:14px;}
	.dbList li a{color:#333;}
</style>
</head>
<body>
	<ul class="dbList" style="">
		<?php if (!empty($dbs)):?>
		<?php foreach ($dbs as $db):?>
		<li>
			<span class="ico wingbtn">:</span>
			<a href="javascript:void(0)" title="<?php echo $db['Database']?>"><?php echo $db['Database']?></a>
			<div class="tableList" style="display:none;"></div>
		</li>
		<?php endforeach;?>
		<?php endif;?>
	</ul>
</body>
</html>