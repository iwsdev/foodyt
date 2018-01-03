<?php
/*
Template Name:Coming soon page
*/



get_header();?>

<section id="my-account" class="profilePage">
	<div class="container">
		
		<div class="row">
			<div class="col-md-3 account-menu">
				<h3>My Account</h3>
				          <?php wp_nav_menu( array( 'theme_location' => 'sidebar-menu')); ?>

			</div>
			
			<div class="col-md-9 account-details">
			<br>
			<br>
			<br>
			<h3>Coming Soon</h3>
			</div>			
		</div>		
	</div>
</section>

</section>


<?php get_footer();
?>
