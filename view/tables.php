<table border="0" cellpadding="0" cellspacing="0" style="margin-left:15px;">
<?php foreach ($tables as $table) :?>
	<tr>
		<td><span class="ico wingbtn">+</span></td>
		<td><span class="table" onclick="showData(this)"><?php echo array_pop($table)?></span></td>
	</tr>
<?php endforeach;?>
</table>