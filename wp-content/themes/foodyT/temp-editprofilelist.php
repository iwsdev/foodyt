<?php
/*
Template Name:Edit Restaurant Profile Page 
*/



get_header();?>

 

<section id="my-account" class="manageplan">
	<div class="container">
		
		<div class="row">
			<div class="col-md-3 col-md-4 col-xs-12">
				<h3>My Account</h3>
				          <?php wp_nav_menu( array( 'theme_location' => 'sidebar-menu')); ?>

			</div>
			
			<div class="col-md-9 col-sm-8 col-xs-12">
			
				<h3>Add Dish</h3>
				<div class="menu">
					<ul>
						<li>
							<figure><img src="<?php get_template_directory_uri(); ?>/images/product.jpg" alt="" /></figure>
							<div class="description">
								<div class="title">
									<h4>OH Mexico! <span>(In Review)</span></h4>
									<div class="btn">
										<a href="#">Edit</a>
										<a href="#">Delete</a>
									</div>
								</div>
								<h6>Size(optional)</h6>
								<p>Av.San Francisco Javier 5,Sevilla Lorem ipsum dolor sit amet, consectetuer doloret adipiscing elit. Aenean commodo ligula eget dolor. </p>
							</div>
						</li>
						
						<li>
							<figure><img src="<?php get_template_directory_uri(); ?>/images/product.jpg" alt="" /></figure>
							<div class="description">
								<div class="title">
									<h4>OH Mexico! <span>(In Review)</span></h4>
									<div class="btn">
										<a href="#">Edit</a>
										<a href="#">Delete</a>
									</div>
								</div>
								<h6>Size(optional)</h6>
								<p>Av.San Francisco Javier 5,Sevilla Lorem ipsum dolor sit amet, consectetuer doloret adipiscing elit. Aenean commodo ligula eget dolor. </p>
							</div>
						</li>
						
						<li>
							<figure><img src="<?php get_template_directory_uri(); ?>/images/product.jpg" alt="" /></figure>
							<div class="description">
								<div class="title">
									<h4>OH Mexico! <span>(In Review)</span></h4>
									<div class="btn">
										<a href="#">Edit</a>
										<a href="#">Delete</a>
									</div>
								</div>
								<h6>Size(optional)</h6>
								<p>Av.San Francisco Javier 5,Sevilla Lorem ipsum dolor sit amet, consectetuer doloret adipiscing elit. Aenean commodo ligula eget dolor. </p>
							</div>
						</li>
					</ul>				
				</div>			
				
				
			</div>			
		</div>		
	</div>
</section>

</section>


<?php get_footer();
?>
