<?php
/*
Template Name:Login page
*/



get_header();?>

 

<section id="login" class="login fheight" style="background:url(<?php echo get_template_directory_uri(); ?>/assets/images/home-banner.jpg) no-repeat; background-position:center center; background-size:cover">
	<div class="inner-cell">
	<div class="container">
		
		<div class="row">
			<div class="col-md-12">
			<?php if($_REQUEST['login']=='failed'){?>
					 <p id="incorect_login"><?= $_SESSION['lan']['login']['error']?></p>
			<?php } ?>
				<div class="login-form">
                    <?php
                    $redirectUrl = get_the_permalink(224);
					$args = array(
						'echo'           => true,
						'remember'       => true,
						'redirect'       => $redirectUrl,
						'form_id'        => 'loginform',
						'id_username'    => 'user_login',
						'id_password'    => 'user_pass',
						'id_remember'    => 'rememberme',
						'id_submit'      => 'wp-submit',
						'label_username' => $_SESSION['lan']['login']['username'],
						'label_password' => $_SESSION['lan']['login']['password'],
						'label_remember' => $_SESSION['lan']['login']['remember'],
						'label_log_in'   => __( 'Log In' ),
						'value_username' => '',
						'value_remember' => false
					);
                    wp_login_form_by_jai($args); ?> 

					<a  id="forgetPassword" href="https://foodyt.com/wp-login.php?action=lostpassword" title="Lost Password"><?= $_SESSION['lan']['login']['forget_pass']?></a>
					
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>



<?php get_footer();
?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#user_login').attr('required','true');
		$('#user_pass').attr('required','true');
	});
</script>

<style>
.current-menu-item a {
    color: #fff!important;
}
</style>