<?php
/*
Template Name:facturacion page
*/
get_header();?>
<?php
 global $wpdb;
 $paymentTable = $wpdb->prefix."payment";
 $userId = get_current_user_id();
 $billing_type = get_user_meta($userId,'billing_type',true);
 if($billing_type){
 $result = $wpdb->get_results("SELECT * from $paymentTable where user_id=$userId AND payment_status='active'",OBJECT);
 }else{
 $result =array();
 }

?>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" media="all" />
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" media='all' />
  
<section id="my-account" class="logincredential">
	<div class="container">
		
        <?php include 'usernotification.php'; ?>
		<div class="row">
			<div class="col-md-3 col-sm-4 col-xs-12 account-menu">
				<h3><?= $_SESSION['lan']['my_account']?></h3>

          <?php
          if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es'){  wp_nav_menu(array('theme_location'=>'sidebar-menu'));}
          else{
              wp_nav_menu(array('theme_location'=>'sidebar-menu-english'));
          }
          ?>
			</div>
			
			<div class="col-md-9 col-sm-8 col-xs-12 account-details">
			    <h3>
            
            <?= $_SESSION['lan']['billing']['bill']?>

            <a class="btn_menu"  href="<?php echo site_url()."/facturacion-form/"?>"><?= $_SESSION['lan']['information_fiscal'];?></a>
            
            </h3>
				<div class="wrapped">
				    
			    <div class="fr-table">
                    <b><?= $_SESSION['lan']['invoice']['listofinvoice']?></b>
					
                     <table class="package table table-striped" id="invoiceList">
                        <thead>
                        <tr>
                        <th><?= $_SESSION['lan']['invoice']['invoice_no']?></th>
                        <th><?= $_SESSION['lan']['invoice']['dateIssue']?></th>
                        <th><?= $_SESSION['lan']['invoice']['amt']?></th>
                        <th><?= $_SESSION['lan']['invoice']['download']?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
	                         foreach($result as $data){ 
								 $amount = $data->amount;
								 $vat = $data->vat;
								 $vatAmount = (($amount*$vat)/100);
                                 $totalAmount = $vatAmount+$amount;
								 $totalAmount = number_format($totalAmount ,2);

							?>
                                <tr>
                                    <td><?php echo $data->invoice_no?></td>
                                    <td><?php 
									$created_date= strtotime($data->created_date);
									echo date('d', $created_date);
									echo " ".date('M', $created_date);
									echo ", ".date('Y', $created_date);?></td>
                                    <td><?php echo number_format($totalAmount,2);?>€</td>
                                    <td><a href="<?php echo site_url()?>/facturacion-detail/?id=<?php echo $data->id?>&uid=<?php echo $data->user_id?>"><img src="<?php echo get_template_directory_uri()?>/assets/images/pdf_icon.png" width="35" height="30" /></a></td>
                                </tr>
                            <?php }
						 ?>
                        </tbody>
                        </table>
                   </div>
				
				</div>
			</div>			
		</div>		
	</div>
</section>
<?php get_footer();?>
 <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
 <?php 
 if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es')
 { 
 ?>

<script>
        jQuery(document).ready(function () {
            jQuery('#invoiceList').DataTable({
  "language": {
    "sSearch": "Buscar :",
    "sLengthMenu" : "Mostrar _MENU_ Entradas",
    "sInfo" : "Mostrando _START_ to _END_ of _TOTAL_ entradas",
    "sZeroRecords" : "No hay datos disponibles",
    "paginate": {
      "previous": "Anterior",
      "next" : "Siguiente",
    }
  }
} );
        });
    </script>

 <?php }else{?>

<script>
        jQuery(document).ready(function () {
            jQuery('#invoiceList').DataTable();
        });
    </script>

 <?php }?>
    
    <style>
	#invoiceList tr,td{text-align:center;}
	#invoiceList tr,th{text-align:center;}
	</style>