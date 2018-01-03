<?php
/*
Template Name:Login Credential page
*/



get_header();?>
<?php
 global $wpdb;
 $userTable = $wpdb->prefix."users";

 if($_REQUEST['password']){
 	$pass = $_REQUEST['password'];
 	$new_pass = $_REQUEST['new_password'];
    $user_id = get_current_user_id();
    $results = $wpdb->get_row( "SELECT * FROM $userTable WHERE ID = $user_id",ARRAY_A );
	// echo "<pre>";
 	// print_r($results);
 	// echo "User Name:".$results['user_pass'];
 	$wp_hasher = new PasswordHash(8, TRUE);
	$password_hashed = $results['user_pass'];
	$plain_password = $pass;
   if($wp_hasher->CheckPassword($plain_password, $password_hashed)) {
	    $set=1;
	   $hash_new = wp_hash_password( $new_pass ) ;
					$wpdb->update( 
					$userTable, 
					array( 
						'user_pass' => $hash_new
					), 
					array( 'ID' => $user_id ), 
					array( 
						'%s'	// value1
					), 
					array( '%d' ) 
				);
	} else {
	    $set=0;
	}

	
 }

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
			<form method="post" >
				<h3><?= $_SESSION['lan']['my_account']?></h3>
				<?php 
 						if($_REQUEST['password']){
 							 if($set==1){
 							 	echo "<p style='color:green;text-align: center;'>Yes password has been change.</p>";?>
								    <script>
									 setTimeout(function(){ 
									window.location.href = 'http://cmsbox.in/wordpress/foodyT/login/'; }, 2000);
									</script>
 							<?php }
 							 if($set==0){?>
 					        	<p style='color:red;text-align: center;'> <?= $_SESSION['lan']['login_credential']['error']?></p>
 							<?php }

 						}
				?>
				<div class="wrapped">
				<div class="login-area text-center">
					<h2><?= $_SESSION['lan']['login_credential']['manage_credential']?></h2>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="c_password"><?= $_SESSION['lan']['login_credential']['reset_pass']?></label>
								<input type="password" placeholder="<?= $_SESSION['lan']['login_credential']['reset_pass']?>" class="form-control" name='password' id="current-password" required="true">
							</div>
						</div>
						
						<div class="col-md-12">
							<div class="form-group">
								<label for="address"><?= $_SESSION['lan']['login_credential']['new_pass']?></label>
								<input type="password" placeholder="<?= $_SESSION['lan']['login_credential']['new_pass']?>" name='new_password' class="form-control" id="password" required="true">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="address"><?= $_SESSION['lan']['login_credential']['confirm_new_pass']?></label>
								<input type="password" placeholder="<?= $_SESSION['lan']['login_credential']['confirm_new_pass']?>" class="form-control"  id="confirm_password" required="true">
							</div>
						</div>
						
					</div>
					<div class="row">
					<div class="col-md-12">
						<input type="submit" value="<?= $_SESSION['lan']['login_credential']['submit']?>" id="submitButton">
					</div>
				</div>
				</div>			
				
				</div>
				</form>
			</div>			
		</div>		
	</div>
</section>




<?php get_footer();
?>
<script type="text/javascript">
	$('#confirm_password').on('keyup', function () {
    if ($(this).val() == $('#password').val()) {
        $('#confirm_password').css('border', '1px solid green');
        $('#submitButton').css('pointer-events' ,'inherit');
        $('#submitButton').css('cursor' ,'pointer');

    } else
     {
      $('#confirm_password').css('border', '1px solid red');
      $('#submitButton').css('pointer-events' ,'none');
      $('#submitButton').css('pointer-events' ,'none');
      $('#submitButton').css('cursor' ,'none');
     }
});
</script>