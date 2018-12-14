<?php 
require_once 'core.php';
$dbs = Tini::readIni(CONFPATH.'database.ini');
$dbname = empty($_REQUEST['db']) ? $dbs['default'] : $_REQUEST['db'];
$default = array_key_exists($dbname, $dbs) ? $dbs[$dbname] : array();
$default['name'] = $dbname;
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="source/css/comm.css"/>
	<style type="text/css">
		#main_background{background-color:#465A7D;height:100%;}
		#main_connect{background-color:#EBEBEB;width: 600px;height:455px;border: 1px solid #D3D3D3;position:absolute;left:0;top:0;bottom:0;right:0;margin:auto;}
		#main_connect .title{padding:5px;font-size:14px;text-align:center;}
		
		#main_connect .body{background-color:#F0F0F0;border:1px solid #DADADA;margin:0 5px;padding:10px;}
		
		#main_connect .content{border-bottom:1px solid #A0A0A0;padding-bottom:10px;text-align:left;height:360px;}
		#main_connect .logo{width:150px;float:left;padding-right:10px;}
		#main_connect .connect{overflow:auto;}
		
		#main_connect .btns button{width:75px;}
		
		#main_connect .dbs{margin-top:10px;}
		#main_connect .dbs label{width:80px;float:left;}
		#main_connect .dbs div{overflow:auto;}
		#main_connect .dbs div select{width:100%;}
		
		#main_connect .options{margin-top:10px;}
		#main_connect .options ul{border-color: #A5A5A5;}
		#main_connect .options li{background-color:#E9E9E9;border-color:#A5A5A5;min-width:40px;}
		#main_connect .options li.checked{background-color:#FFF;padding-top:5px;}
		
		#main_connect .forms{border:1px solid #A5A5A5;border-top:0;}
		#main_connect .forms table{width:100%;border-spacing:5px;}
		#main_connect .forms input[type=text]{width:100%;height:25px;}
		#main_connect .forms input.pass{width:185px;}
		#main_connect .forms input.second{width:100px;}
		#main_connect .forms fieldset {border:1px solid #A5A5A5;}
		
		#main_connect .footer{border-top:1px solid #FFF;padding-top:5px;text-align:right;}
		#main_connect .footer button{width:120px;margin-left:20px;}
	</style>
	<script type="text/javascript" src="source/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#select_db').on('change', function(){
				var op = this.options[this.selectedIndex];
				console.log($(op));
				document.connect.name.value = this.value;
				document.connect.host.value = op.attributes['host'].value;
				document.connect.port.value = op.attributes['port'].value;
				document.connect.user.value = op.attributes['user'].value;
				document.connect.pass.value = op.attributes['pass'].value;
				document.connect.dtbs.value = op.attributes['default'].value;
			});
			
		})
	</script>
</head>
<body>
	<div id="main_background">
		<div id="main_connect">
			<div class="title">连接到我的SQL主机</div>
			<div class="body">
				<div class="content">
					<div class="logo">
						<img alt="mysql" src="source/img/mysql.png">
					</div>
					<div class="connect">
						<div class="btns">
							<button>新建</button>&nbsp;
							<button>克隆</button>&nbsp;
							<button>保存</button>&nbsp;
							<button>重命名</button>&nbsp;
							<button>删除</button>
						</div>
						<div class="dbs">
							<label for="select_db">保/存的连接</label>
							<div>
								<select id="select_db">
									<?php foreach($dbs as $name => $db):?>
									<?php if(!is_array($db))continue?>
									<option <?php foreach ($db as $k=>$v) echo "{$k}='{$v}'"?> <?php if($name === $dbs['default']) echo 'selected'?>><?php echo $name?></option>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="options">
							<ul class="tab_list">
								<li class="checked">MySQL</li>
								<li>HTTP</li>
								<li>SSH</li>
								<li>SSL</li>
								<li>高级功能</li>
							</ul>
						</div>
						<div class="forms">
							<form name="connect" action="connect.php" method="post">
								<input type="hidden" name="name" value="<?php echo $default['name']?>"/>
								<table>
									<tr>
										<td><label>我的SQl主机地址</label></td>
										<td><input type="text" name="host" value="<?php if(isset($default['host'])) echo $default['host'];?>"/></td>
									</tr>
									<tr>
										<td><label>用户名</label></td>
										<td><input type="text" name="user" value="<?php if(isset($default['user'])) echo $default['user'];?>"/></td>
									</tr>
									<tr>
										<td><label>密码</label></td>
										<td>
											<input type="text" name="pass" value="<?php if(isset($default['pass'])) echo $default['pass'];?>" class="pass"/>
											<input type="checkbox" name="save_pass" id="save_pass"/>
											<label for="save_pass">保存密码</label>
										</td>
									</tr>
									<tr>
										<td><label>端口</label></td>
										<td><input type="text" name="port" value="<?php echo (isset($default['port'])) ? $default['port'] : 3306;?>" class="pass"/></td>
									</tr>
									<tr>
										<td><label>数据库</label></td>
										<td><input type="text" name="dtbs" value="<?php if(isset($default['default'])) echo $default['default'];?>"/></td>
									</tr>
									<tr>
										<td colspan="2">&nbsp;(使用来分割多个数据库.留下空白以显示全部) </td>
									</tr>
									<tr>
										<td colspan="2">
											<input type="checkbox" name="use_zip" id="use_zip"/>
											<label for="use_zip">使用压缩协议</label>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<fieldset style="float:left;display:inline-block;">
												<legend>会话空闲超时</legend>
												<input type="radio" name="time_out" id="time_default" value="default">
												<label for="time_default">默认</label>
												<input type="radio" name="time_out" value="input">
												<input class="second" name="time_out_sec" id="time_out_sec"/>
												<label for="time_out_sec">（秒）</label>
											</fieldset>
											<fieldset>
												<legend>保持活动的间隔</legend>
												<input class="second" name="keep_alive_sec" id="keep_alive_sec"/>
												<label for="keep_alive_sec">（秒）</label>
											</fieldset>
										</td>
									</tr>
								</table>
							</form>
						</div>
					</div>
				</div>
				<div class="footer">
					<button name="connect" onclick="document.connect.submit()">连接(C)</button>
					<button>取消(L)</button>
					<button>测试链接</button>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
