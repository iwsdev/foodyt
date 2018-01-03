<script type="text/javascript">
	function deletepost(id){
		var con=confirm("Are you want delete this..?");
		if(con){
			window.location.href='uses.php?page=userupload&actions=deletedata&deleteId='+id;
		}
	}
</script>
<?php
 global $wpdb;
 $userTable = $wpdb->prefix."payment";
 $userId = get_current_user_id();
 $userid = $_REQUEST['id'];
 $res = $wpdb->get_results("SELECT * from $userTable where user_id=$userid AND payment_status='active'",OBJECT);
?>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" media="all" />
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" media='all' />
  
<section id="my-account" style="width:98%;margin:0 auto;padding-top:30px;">
	
                 <table class="package table table-striped" id="invoiceListAdmin">
                        <thead>
                        <tr>
                        <th style="border: 1px solid gray;">Sr No.</th>
                        <th style="border: 1px solid gray;">Invoice No</th>
                        <th style="border: 1px solid gray;">Date of issue</th>
                        <th style="border: 1px solid gray;">Amount</th>
                        <th style="border: 1px solid gray;">Download</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;foreach($res as $data)
								{ 
								$amount = $data->amount;	
							    $vat = $data->vat;
                                $vatAmount = (($amount*$vat)/100);
                                $totalAmount = $vatAmount+$amount;
								$totalAmount = number_format($totalAmount ,2);
							?>
                                <tr>
                                    <td><?php echo $i?></td>
                                    <td><?php echo $data->invoice_no?></td>
                                    <td><?php 
									$created_date= strtotime($data->created_date);
									echo date('d', $created_date);
									echo " ".date('M', $created_date);
									echo ", ".date('Y', $created_date);?></td>
                                    <td><?php echo $totalAmount;?>€</td>
                                    <td><a href="<?php echo site_url()?>/facturacion-detail/?id=<?php echo $data->id?>&uid=<?php echo $data->user_id?>"><img src="<?php echo get_template_directory_uri()?>/assets/images/pdf_icon.png" width="35" height="30" /></a></td>
                                </tr>
                            <?php $i++; } ?>
                        </tbody>
                       </table>
    
</section>
 <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script>
        jQuery(document).ready(function () {
            jQuery('#invoiceListAdmin').DataTable();
        });
    </script>
    <style>
	#invoiceListAdmin tr,td{text-align:center;border: 1px solid gray;}
	#invoiceListAdmin tr,th{text-align:center;border: 1px solid gray;}
		
	</style>
