<table class="infoTable" cellpadding="0" cellspacing="1" border="0" width="100%">
	<?php if(!empty($infos)):?>
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
		<td><?php echo $info['TABLE_NAME']?></td>
		<td><?php echo $info['TABLE_COMMENT']?></td>
		<td><?php echo $info['ENGINE']?></td>
		<td><?php echo $info['TABLE_COLLATION']?></td>
		<td><?php echo $info['DATA_LENGTH']?></td>
		<td><?php echo $info['INDEX_LENGTH']?></td>
	</tr>
	<?php endforeach;?>
	<?php endif;?>
	<?php if(!empty($columns)):?>
	<tr>
		<th>Field</th>
		<th>Type</th>
		<th>Collation</th>
		<th>Null</th>
		<th>Key</th>
		<th>Default</th>
		<th>Comment</th>
	</tr>
	<?php foreach ($columns as $col):?>
	<tr>
		<td><?php echo $col['Field']?></td>
		<td><?php echo $col['Type']?></td>
		<td><?php echo $col['Collation']?></td>
		<td><?php echo $col['Null']?></td>
		<td><?php echo $col['Key']?></td>
		<td><?php echo $col['Default']?></td>
		<td><?php echo $col['Comment']?></td>
	</tr>
	<?php endforeach;?>
	<?php endif;?>
</table>