<?php
/*
Template Name:Contact page
*/



get_header();?>

 

<section id="contact" class="contact">
	<div class="container">
		
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<?php
				if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es'){
				 echo get_post_meta(162,'contact_page_address',true);
				 }else{
				 	 echo get_post_meta(162,'address_english',true);
				 	}?>
				<div class="contact_form">
				  <?php 
				  if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es'){
				      echo do_shortcode('[contact-form-7 id="257" title="Contact Spanish"]');
				      }else
				      {
				      echo do_shortcode('[contact-form-7 id="1036" title="Contact English"]');
				     }

				  ?>
				</div>

				
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
			<?php echo get_post_meta(162,'map',true);?>
			<!-- <div id="map_canvas_custom_300820" style="width:100%; height:400px" ></div>
			<script type="text/javascript">
(function(d, t) {var g = d.createElement(t),s = d.getElementsByTagName(t)[0];
   g.src = "http://map-generator.net/en/maps/300820.js?point=New+York%2C+NY%2C+USA";
   s.parentNode.insertBefore(g, s);}(document, "script"));</script>
			</div> -->
		</div>		
	</div>
</section>


<?php get_footer();
?>
