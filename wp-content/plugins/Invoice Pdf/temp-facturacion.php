<?php
/*
Template Name:facturacion page
*/
get_header();?>
<?php
 global $wpdb;
 $paymentTable = $wpdb->prefix."payment";
 $userId = get_current_user_id();
 $res = $wpdb->get_results("SELECT * from $paymentTable where user_id=$userId AND payment_status='active'",OBJECT);
?>
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
			    <h3><?= $_SESSION['lan']['billing']['bill']?></h3>
				<div class="wrapped">
				    
			    <div class="fr-table">
                    <b><?= $_SESSION['lan']['invoice']['listofinvoice']?></b>
					
                      <table width="100%">
                        <thead>
                        <tr>
                        <th><?= $_SESSION['lan']['invoice']['invoice_no']?></th>
                        <th><?= $_SESSION['lan']['invoice']['dateIssue']?></th>
                        <th><?= $_SESSION['lan']['invoice']['amt']?></th>
                        <th><?= $_SESSION['lan']['invoice']['download']?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($res as $data)
									{
										$amount = $data->amount;	
							   $vat = get_post_meta( 167, 'vat', true);
                               $vatAmount = (($amount*$vat)/100);
                        
                               $totalAmount = $vatAmount+$amount;
							?>
                                <tr>
                                    <td><?php echo $data->id?></td>
                                    <td><?php echo $data->created_date?></td>
                                    <td><?php echo $totalAmount?>€</td>
                                    <td><a href="<?php echo site_url()?>/facturacion-detail"><img src="<?php echo get_template_directory_uri()?>/assets/images/pdf_icon.png" width="35" height="30" /></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        </table>
                   </div>
				
				</div>
			</div>			
		</div>		
	</div>
</section>
<?php get_footer();?>