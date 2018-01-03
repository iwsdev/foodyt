<?php
global $wpdb;
$cuisineTable = $wpdb->prefix."cuisine";
$plugins_url = plugins_url( '', __FILE__ );
if(isset($_POST['submit'])){
// $update="UPDATE $cuisineTable SET `cuisine_name`='$_POST[cuisine_name]' where id='$_GET[id]'";
// $exute=mysql_query($update) or die(mysql_error());
$exute = $wpdb->insert( 
	$cuisineTable, 
	array( 
		'cuisine_name' => $_POST[cuisine_name],	// string
		'cuisine_name_es' => $_POST[cuisine_name_es], // string
		'status' => $_POST[status], // string
	),
	array( 
		'%s',	// value1
		'%s',	// value1
		'%d'	// value1
	)
);
if($exute){
	echo "<p class='successCuision'>Your Cuision has been updated successfully.</p>";
	// echo "<script>
	// document.location.href='options-general.php?page=cuisine';
	// </script>";
}
}
$getData=$wpdb->get_row("select * from $cuisineTable where id='$_GET[id]'");
?>
<link rel="stylesheet" href="<?php echo $plugins_url;?>/cuision.css" type='text/css' media='all' />
<center>
	<form method="post">
	<table class="addjob">
		<tr>
			<th align="center" colspan="2">Add Cuision</th>
		</tr>
		<tr>
			<td>Cuisine Name (English) :</td>
			<td><input type="text" name="cuisine_name" required=""  value=""></td>
		</tr>
		
		<tr>
			<td>Cuisine Name (Spanish):</td>
			<td><input type="text" name="cuisine_name_es" required="" value=""></td>
		</tr>

		<tr>
			<td>Status:</td>
			<td><select name="status">

					<option  value="1">Enable</option>
					<option value="0">Disable</option>
			   </select>
		</tr>
	
		<tr>
		<td align="center" colspan="2"><input class="buttons" type="submit" name="submit" style='float:right;' value="Add Cuision" />
				&nbsp&nbsp<a class="buttons" style='float:left;' href="options-general.php?page=cuisine">Back</a>
			</td>
		</tr>
	</table>
</center>
</form>