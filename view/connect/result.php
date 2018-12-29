<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link type="text/css" rel="stylesheet" href="source/css/comm.css"/>
<script type="text/javascript" src="source/js/jquery-1.10.2.min.js"></script>
<style type="text/css">
	html,body{overflow-x:hidden;height:100%;}
	.tabList{margin:0;width:100%;list-style:none;word-wrap:break-word;white-space:nowrap;background-color:#465A7D;border-bottom:5px solid #FCE198;font-size:0;}
	.tabList li{color:#FFF;display:inline-block;padding:4px 15px;margin:0;cursor:pointer;border-right:1px solid #C4CDDA;border-bottom-style:none;vertical-align:bottom;position:relative;background-color:#465A6E;}
	.tabList li.menuCheck{color:#000;font-weight:bold;background-color:#FCE6AA;}
	.tabList li span{font-size:12px;}
	
	.scollView{position:absolute;top:30px;left:0;bottom:0;width:100%;overflow:auto;}
	.bottomView{position:absolute;bottom:0;width:100%;height:20px;line-height:20px;background-color:#465A7D;}
	.bottomView span{color:#FFF;display:block;margin-left:5px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
	.dataView{height:600px;line-height:600px;overflow:auto;overflow-x:hidden;}
	
	.searchTable{border-collapse:collapse;color:#333;table-layout:fixed;}
	.searchTable tr:nth-child(odd){background-color:#F4F4F4;}
	.searchTable th, .searchTable td{border:1px solid #A0A0A0;padding:0 3px;}
	.searchTable th{background-color:#C9C6B8;font-weight:normal;text-align:left;}
	.searchTable td{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
	.searchTable tr.selected{background-color:#B4CCEE;}
	.searchTable td.selected{border:2px solid black;}
	
	#viewResult{margin:2px;}
	#viewResult .title{border:1px dashed; padding:5px;margin-bottom:5px;}
	#viewResult .sql{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;border-top:1px dashed;margin-top:5px;}
	#viewResult hr{border:1px dashed; margin-bottom:5px;}
	
	.infoTable{border:1px solid #EEE1FF;}
	.infoTable tr:nth-child(even){background-color:#E2E5EE;}
	.infoTable th{background-color:#E0E0E0;text-align:left;}
	.infoTable th, .infoTable td{padding:3px 5px;}
	.flex{margin:0;display:flex;align-items:baseline;justify-content:space-between;cursor:pointer;}
	.flex button{padding:0;border:0;background-color:transparent;}
</style>
<script type="text/javascript">
	$(function(){
		$('.tabList li').on('click', function(){
			if($(this).hasClass('menuCheck') != false){
				return false;
			}
			$('.tabList li.menuCheck').removeClass('menuCheck');
			$(this).addClass('menuCheck');
			$('div.showView').hide();
			$('#view'+this.title).show();
		});
		
		$('.searchTable tr').on('mousedown', function(){
			$('.searchTable tr.selected').removeClass('selected');
			$(this).addClass('selected');
		});
		$('.searchTable td').on('mousedown', function(){
			$('.searchTable td.selected').removeClass('selected');
			$(this).addClass('selected');
		});
		$('.searchTable td').on('dblclick', function(){
			if($(this).find('input').length != 0){
				return false;
			}
			this.title = this.innerHTML;
			this.style.padding = '0';
			var input = document.createElement('input');
			input.className = 'editInput';
			input.value = this.innerHTML;
			input.style.border = '0';
			input.style.width = this.clientWidth+'px';
			input.onblur = function(){
				console.log($(this).parentsUntil('tr').parent().find('input[type="checkbox"]').val());
				$(this).parent().removeAttr('style').html(this.value);
			}
			$(this).html(input);
			input.focus();
		});
		
		$('.searchBtn button.import').on('click', function(){
			$(this).next('select').show().focus();
		});
		
		$('select[name="export"]').on('change', function(){
			this.form.submit();
			this.selectedIndex = -1;
			$(this).hide();
		}).on('blur', function(){
			$(this).hide();
		});

		$('p.flex').on('click', function(){
			$('p.flex').not(this).find('button').text('5').hide();
			var sort = $(this).find('button');
			if(sort.css('display') == 'none'){
				document.result.sort.value = 'ASC';
				sort.css('display', 'block');
			}
			sort[0].click();
		})
	})
</script>
<title>sqlyog_result</title>
</head>
<body>
	<div>
		<div>
			<ul class="tabList">
				<?php foreach ($searchs as $index => $res):?><li title="Search_<?php echo $index?>"<?php if ($index=='1'):?> class="menuCheck"<?php endif;?>><span><a class="wingbtn">3</a> 查询结果_<?php echo $index?></span></li><?php endforeach;?>
				<?php if ($results['count'] > 0):?><li title="Result"<?php if (count($searchs) < 1 && $results['count'] > 0):?> class="menuCheck"<?php endif;?>><span><a class="wingbtn">+</a> 执行结果</span></li><?php endif;?>
				<li title="table"><span><a class="wingbtn">4</a> 表数据</span></li>
				<li title="Info"><span><a class="wingbtn">2</a> 信息</span></li>
			</ul>
		</div>
		<div class="showView" style="display:none;">
			<div class="scollView" style="bottom:25px;">
				~~~~~~~~~~~~~~~~~~~~~~<br/>
				~~~~~~~~~~~~~~~~~~~~~~<br/>
				~~~~~~~~~~~~~~~~~~~~~~<br/>
				~~~~~~~~~~~~~~~~~~~~~~<br/>
				~~~~~~~~~~~~~~~~~~~~~~<br/>
				~~~~~~~~~~~~~~~~~~~~~~<br/>
				~~~~~~~~~~~~~~~~~~~~~~<br/>
			</div>
			<div class="bottomView" style="">
				<span style="padding-left:3px;">bottom</span>
			</div>
		</div> 
		<?php foreach ($searchs as $k => $res):?>
		<div class="showView" id="viewSearch_<?php echo $k?>" style="display:<?php if($k=='1')none;?>;">
			<form name="result" action="index.php?ctrl=connect/result&name=<?php echo $name;?>" method="post">
				<div class="searchBtn">
					<input type="hidden" name="sql" value="<?php echo $res['sql'];?>"/>
					<input type="hidden" name="sort" value="<?php echo (!empty($res['order']) && $res['sort'] == 'ASC') ? 'DESC' : 'ASC'?>"/>
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tr>
							<td width="16">
								<div class="selectView">
									<button type="button" class="import wingbtn" title="导出为...">=</button>
									<select name="export" size="3" style="display:none;">
										<option value="1">SQL</option>
										<option value="2">CSV</option>
										<option value="3">JSON</option>
										<option value="4">HTML</option>
									</select>
								</div>
							</td>
							<td width="16"><button name="export" value="1" class="wingbtn" title="导出为SQL">&lt;</button></td>
							<td width="99%"></td>
							<?php if(!empty($res['page'])):?>
							<td>页:</td>
							<td><button class="webbtn" name="prev" value="<?php echo $res['page']['prev'];?>"<?php if ($res['page']['num'] <= 1 || $res['page']['num'] > $res['page']['max']):?>disabled<?php endif;?>>3</button></td>
							<td><input name="page" value="<?php echo $res['page']['num'];?>" onchange="this.form.submit()"/></td>
							<td><button class="webbtn" name="next" value="<?php echo $res['page']['next'];?>"<?php if ($res['page']['num'] >= $res['page']['max']):?>disabled<?php endif;?>>4</button></td>
							<td style="min-width:32px;">行数:</td>
							<td><input name="limit" value="<?php echo $res['page']['size'];?>" onchange="this.form.submit()"/></td>
							<td style="min-width:20px;"></td>
							<?php endif;?>
						</tr>
					</table>
				</div>
				<div class="scollView" style="top:55px;bottom:20px;">
					<table class="searchTable" cellpadding="0" cellspacing="0" border="0">
						<thead>
							<tr>
								<th><input type="checkbox" name="ckAll"/></th>
								<?php foreach ($res['data']['cols'] as $col_name):?>
								<th>
									<p title="<?php echo $col_name;?>" class="flex">
										<span><?php echo $col_name;?></span>
										<button name="order" class="webbtn" value="<?php echo ($res['order'] !== $col_name || $res['sort'] !== 'DESC') ? $col_name : '';?>" style="display:<?php echo ($res['order'] == $col_name) ? 'block' : 'none';?>">
											<?php echo ($res['order'] == $col_name && $res['sort'] == 'DESC') ? 6 : 5;?>
										</button>
									</p>
								</th>
								<?php endforeach;?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($res['data']['rows'] as $row):?>
							<tr>
								<td><input type="checkbox" name="ids[]" value="<?php echo current($row);?>"/></td>
								<?php foreach ($row as $data):?>
								<td style="max-width:200px;" title="<?php echo htmlentities($data);?>"><?php echo htmlentities($data);?></td>
								<?php endforeach;?>
							</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
				<div class="bottomView">
					<span><?php echo $res['sql'];?></span>
				</div>
			</form>
		</div>
		<?php endforeach;?>
		<?php if($results['count'] > 0):?>
		<div class="showView scollView" id="viewResult" style="display:<?php if (!empty($searchs)) echo 'none'?>;">
			<div class="title">共[<?php echo $results['count']?>]条请求, [<?php echo $results['success']?>]成功, [<?php echo $results['fail']?>] 失败</div>
			<?php foreach ($results['detail'] as $sql => $sql_res):?>
			<div class="sql" title="<?php echo $sql?>">执行:<?php echo $sql?></div>
			<div><?php if($sql_res['state'] == '1'):?>共[<?php echo $sql_res['affect']?>]条受到影响<?php else: ?>错误代码:[<?php echo $sql_res['errno']?>] &nbsp; 错误描述:<?php echo $sql_res['error']?><?php endif;?></div>
			<div>执行耗时:<?php echo $sql_res['time']?> sec</div>
			<?php endforeach;?>
		</div>
		<?php endif;?>
		<div class="showView scollView" id="viewInfo" style="display:none;">
			<table class="infoTable" cellpadding="0" cellspacing="1" border="0" width="100%">
				<tr>
					<th>TABLE_NAME</th>
					<th>TABLE_COMMENT</th>
					<th>ENGINE</th>
					<th>TABLE_COLLATION</th>
					<th>DATA_LENGTH</th>
					<th>INDEX_LENGTH</th>
				</tr>
				<?php foreach ($infos as $info):?>
				<tr>
					<td><?php echo $info['TABLE_COLLATION']?></td>
					<td><?php echo $info['TABLE_NAME']?></td>
					<td><?php echo $info['TABLE_COMMENT']?></td>
					<td><?php echo $info['ENGINE']?></td>
					<td><?php echo $info['DATA_LENGTH']?></td>
					<td><?php echo $info['INDEX_LENGTH']?></td>
				</tr>
				<?php endforeach;?>
			</table>
		</div>
 	</div>
</body>
</html>