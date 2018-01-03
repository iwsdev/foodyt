 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" media="all" />
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" media='all' />
<?php
global $wpdb;
$userTable = $wpdb->prefix."users";
$restaurant_info_table = $wpdb->prefix."restaurant_infos";
$paymentTable = $wpdb->prefix."payment";
$getgata = $wpdb->get_results("SELECT * FROM $userTable"); 
//echo "<pre>";
//print_r($getgata);
?>
<script type="text/javascript">
	function deletepost(id){
		var con=confirm("Are you want delete this..?");
		if(con){
			window.location.href='options-general.php?page=userupload&actions=deletedata&deleteId='+id;
		}
	}
</script>
<link rel="stylesheet" href="<?php bloginfo('url') ?>/wp-content/plugins/user-uploaded-file/postjob.css" type='text/css' media='all' />

<h5><b>User List </b></h5>

<center style="width: 98%;margin: 0 auto;">
	<table class="listjob" id="userListAdmin">
	<thead>
		<tr>
			<th>s no</th>
			<th>Restaurant Name</th>
			<th>Email id</th>
			<th>Number of Invoices</th>
			<th>View All Invoices</th>
			
		</tr>
	</thead>
	 <tbody>	
		
		<?php
		if($getgata){
		$i=1;
		foreach ($getgata as $key => $data) {
		  	$getgata = $wpdb->get_row("SELECT * FROM $restaurant_info_table where user_id = $data->ID"); 
			if($getgata){ ?>
		
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $getgata->restaurant_name; ?></td>
				<?php 
					  $query1="SELECT count(user_id) as count 
					  FROM $paymentTable where user_id= $data->ID AND payment_status='active'";
					  $getgata1 = $wpdb->get_row($query1);
					?>
				<td><?php echo $data->user_email; ?></td>
				<td><?php echo '<a href="users.php?page=userinvoice&actions=view&id='.$data->ID.'">'.$getgata1->count.'</a>'?></td>
				<td><a class="buttons" href="users.php?page=userinvoice&actions=view&id=<?php echo $data->ID; ?>">View</a></td>
					</tr>
		<?php   $i++; } } } else {
			echo "<tr><td colspan=8> sorry No data</td></tr>";
		} ?>
		  </tbody>
	</table>
</center>
 <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script>
        jQuery(document).ready(function () {
            jQuery('#userListAdmin').DataTable();
        });
    </script>
    <style>
	#userListAdmin tr,td{text-align:center;border:1px solid #b6a4a4;}
	#userListAdmin tr,th{text-align:center;border:1px solid #b6a4a4;}
		.buttons:hover{color:#fff!important;}
		
	</style>