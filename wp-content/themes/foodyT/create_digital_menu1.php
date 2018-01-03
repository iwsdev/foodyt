<?php
/*
Template Name:Create digital Menu 1 page
*/



get_header();?>

 


<section id="cdm" class="cdm fheight" style="background:url(<?php echo get_template_directory_uri(); ?>/assets/images/home-banner.jpg) no-repeat; background-position:center center; background-size:cover">
	<div class="inner-cell">
		<div class="container"> 
		
		<div class="row">
			<div class="col-md-6  col-sm-6 col-xs-12  headings text-left">
				<h2>
					<?php
					 if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es')
						{ 
					    echo get_post_meta(167,'digital_menu_page_title_es',true);
					    }else{
					    echo get_post_meta(167,'digital_menu_page_title_en',true);
					    }?>
				</h2>
					<a class="btn" href="<?php echo get_the_permalink(167);?>"><?php
					 if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es')
						{ 
					    echo get_post_meta(167,'digital_menu_button_text_es',true);
					    }else{
					    echo get_post_meta(167,'digital_menu_button_text_en',true);
					    }?></a>
			</div>
			
			<div class="col-md-6 col-sm-6 col-xs-12 text-center">							
				<div class="video-section">
				<iframe width="100%" height="380" src="<?php echo get_post_meta(167,'youtube_video',true);?>" frameborder="0" allowfullscreen></iframe>
				</div>
			</div>	
		</div>		
	  </div>
    </div>
</section>



<?php get_footer();
?>
