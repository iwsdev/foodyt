<?php
global $wpdb;
$cuisineTable = $wpdb->prefix."cuisine";
$plugins_url = plugins_url( '', __FILE__ );

if(isset($_POST['submit'])){
// $update="UPDATE $cuisineTable SET `cuisine_name`='$_POST[cuisine_name]' where id='$_GET[id]'";
// $exute=mysql_query($update) or die(mysql_error());
$exute = $wpdb->update( 
	$cuisineTable, 
	array( 
		'cuisine_name' => $_POST[cuisine_name],	// string
		'cuisine_name_es' => $_POST[cuisine_name_es],	// string
		'status' => $_POST[status],	// string
	), 
	array( 'ID' => $_GET[id] ), 
	array( 
		'%s',	// value1
		'%s',	// value1
		'%d',	// value1
	), 
	array( '%d' ) 
);
if($exute){
	echo "<p class='successCuision'>Your Cuision has been updated successfully.</p>";
}
}
$getData=$wpdb->get_row("select * from $cuisineTable where id='$_GET[id]'");
?>
<link rel="stylesheet" href="<?php echo $plugins_url;?>/cuision.css" type='text/css' media='all' />
<center>
	<form method="post">
	<table class="addjob">
		<tr>
			<th align="center" colspan="2">Update Cuision</th>
		</tr>
		<tr>
			<td>Cuisine Name (English):</td>
			<td><input type="text" name="cuisine_name" value="<?php if(isset($getData->cuisine_name)) echo $getData->cuisine_name; ?>" /></td>
		</tr>
		<tr>
			<td>Cuisine Name (Spanish):</td>
			<td><input type="text" name="cuisine_name_es" value="<?php if(isset($getData->cuisine_name_es)) echo $getData->cuisine_name_es; ?>" /></td>
		</tr>
		<tr>
			<td>Status:</td>
			<td><select name="status">

					<option <?php if($getData->status==1){echo "selected";} ?> value="1">Enable</option>
					<option <?php if($getData->status==0){echo "selected";} ?> value="0">Disable</option>
			   </select>
		</tr>
	
		<tr>
			<td align="center" colspan="2"><input class="buttons" type="submit" name="submit" value="Update Cuision" style='float:right;'/>
				&nbsp&nbsp<a class="buttons" href="options-general.php?page=cuisine" style='float:left;'>Cancel</a>
			</td>
		</tr>
	</table>
</center>
</form>