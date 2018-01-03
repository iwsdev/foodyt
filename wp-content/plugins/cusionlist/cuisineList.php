<?php
global $wpdb;
$cuisineTable = $wpdb->prefix."cuisine";
include "pagination.class.php";
// $items = mysql_num_rows(mysql_query("SELECT * FROM wp_cuisine;")); // number of total rows in the database
 $dataCount = $wpdb->get_results("SELECT * FROM $cuisineTable");
 $items = count($dataCount);
if($items > 0) {
		$p = new pagination;
		$p->items($items);
		$p->limit(10); // Limit entries per page
		$p->target("admin.php?page=cuisine"); 
		$p->currentPage($_GET[$p->paging]); // Gets and validates the current page
		$p->calculate(); // Calculates what to show
		$p->parameterName('paging');
		$p->adjacents(1); //No. of page away from the current page
				
		if(!isset($_GET['paging'])) {
			$p->page = 1;
		} else {
			$p->page = $_GET['paging'];
		}
		
		//Query for limit paging
		$limit = "LIMIT " . ($p->page - 1) * $p->limit  . ", " . $p->limit;
		
       } 
      else 
          {
				echo "No Record Found";
		 }
$plugins_url = plugins_url( '', __FILE__ );

$query="SELECT * FROM $cuisineTable $limit";
$getgata = $wpdb->get_results($query);
?>
<script type="text/javascript">
	function deletepost(id){
		var con=confirm("Are you want delete this..?");
		if(con){
			window.location.href='admin.php?page=cuisine&actions=deletedata&deleteId='+id;
		}
	}
</script>
<link rel="stylesheet" href="<?php echo $plugins_url;?>/cuision.css" type='text/css' media='all' />
<center>
	<table class="listjob">
		<tr>
			<td align="center" colspan="3"><b>Cuisine List</b></td>
			<td colspan="2" align="right"><a href="admin.php?page=cuisine&actions=add" class="buttons btn-primary"> Add New Cuisine</a></td>
		</tr>
		<tr>
			<th>s no</th>
			<th>Cuisine Name (English)</th>
			<th>Cuisine Name (Spanish)</th>
			<th>Update</th>
			<th>Delete</th>
		</tr>
		<?php
		if($wpdb->query($query)>0){
			if($p->page==1){
			$i=1;}else{
				$i=(($p->page)*10)+1;
			}

		foreach ($getgata as $data) {?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $data->cuisine_name; ?></td>
				<td><?php echo $data->cuisine_name_es; ?></td>
				<td><a class="buttons btn-info" href="options-general.php?page=cuisine&actions=update&id=<?php echo $data->id; ?>">Edit</a></td>
				<td><a onclick="deletepost(<?php echo $data->id; ?>)" class="buttons btn-danger" href="javascript:void(0)">Delete</a></td>
			</tr>
		<?php $i++; } } else {
			echo "<tr><td colspan=8> sorry No data</td></tr>";
		} ?>
		<tr>
			<td align="center" colspan="5">
			   <div class="tablenav">
                  <div class='tablenav-pages'>
                     <?php echo $p->show();  // Echo out the list of paging. ?>
                 </div>
              </div>	
			</td>
	   </tr>
	</table>
</center>