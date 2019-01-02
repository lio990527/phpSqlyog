<form name="dataForm" method="post" onsubmit="return dataQuery(this)">
<div class="searchBtn">
	<input type="hidden" name="db" value="<?php echo $db?>"/>
	<input type="hidden" name="table" value="<?php echo $table?>"/>
	<input type="hidden" name="sort" value="<?php echo $result['sort']?>"/>
	<table border="0" width="100%">
		<tr>
			<td>
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
			<td><button name="export" value="1" class="wingbtn" title="导出为SQL">&lt;</button></td>
			<td width="99%"></td>
			<?php if(!empty($result['page'])):?>
			<td>页:</td>
			<td><button class="webbtn" name="prev" value="<?php echo $result['page']['prev'];?>"<?php if ($result['page']['num'] <= 1 || $result['page']['num'] > $result['page']['max']):?>disabled<?php endif;?>>3</button></td>
			<td><input name="page" value="<?php echo $result['page']['num'];?>" onchange="dataQuery(this.form)"/></td>
			<td><button class="webbtn" name="next" value="<?php echo $result['page']['next'];?>"<?php if ($result['page']['num'] >= $result['page']['max']):?>disabled<?php endif;?>>4</button></td>
			<td style="min-width:32px;">行数:</td>
			<td><input name="limit" value="<?php echo $result['page']['size'];?>" onchange="dataQuery(this.form)"/></td>
			<td style="min-width:20px;"></td>
			<?php endif;?>
		</tr>
	</table>
</div>
<div class="scollView" style="top:55px;bottom:20px;">
	<table class="searchTable" border="0">
		<thead>
			<tr>
				<th><input type="checkbox" name="ckAll"/></th>
				<?php foreach ($result['data']['cols'] as $col):?>
				<th>
					<p title="<?php echo $col['Field'];?>" class="flex">
						<span><?php echo $col['Field'];?></span>
						<button name="order" class="webbtn" value="<?php echo ($result['order'] !== $col['Field'] || $result['sort'] !== 'DESC') ? $col['Field'] : '';?>" style="display:<?php echo ($result['order'] == $col['Field']) ? 'block' : 'none';?>">
							<?php echo ($result['order'] == $col['Field'] && $result['sort'] == 'DESC') ? 6 : 5;?>
						</button>
					</p>
				</th>
				<?php endforeach;?>
			</tr>
		</thead>
		<tbody>
			<?php if(!empty($result['data']['rows'])):?>
			<?php foreach ($result['data']['rows'] as $row):?>
			<tr>
				<td><input type="checkbox" name="ids[]" value="<?php echo current($row);?>"/></td>
				<?php foreach ($row as $data):?>
				<td style="max-width:200px;" title="<?php echo htmlentities($data);?>"><?php echo htmlentities($data);?></td>
				<?php endforeach;?>
			</tr>
			<?php endforeach;?>
			<?php endif;?>
		</tbody>
	</table>
</div>
<div class="bottomView">
	<span style="padding-left:3px;">
		<?php echo $db . '.' . $table?>
	</span>
</div>
</form>