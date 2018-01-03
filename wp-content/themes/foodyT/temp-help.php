<?php
/*
Template Name:Help page
*/



get_header();?>

 

<section id="help" class="help">
	<div class="container">
		
		<div class="row">
			<div class="col-md-6">
				<h3 class="title">Frequent Questions</h3>
			</div>
			
			<div class="col-md-6">
				
				<form method="post">
				<div class="faq-search">
					<i class="fa fa-search"></i>
					<input type="search" name="search" class="search" placeholder="Hello, how can we help you?"/>
				</div>
					<input type="submit" style="visibility: hidden;" />
				</form>

				
			</div>





			
			<div class="col-md-12 tabs">
			 <ul>
				<?php

				global $wpdb; 
		$postTable = $wpdb->prefix."posts";
		$finalArgs =  array (       
		        'posts_per_page'=>5,
		        'order' => 'ASC',
		        'post_type' => 'post' ,
		        'cat' => 4                      
		    );

		    // Create a new instance
		    $searchSchools = new WP_Query( $finalArgs );
		    if(isset($_REQUEST['search'])){
 			$serach = $_REQUEST['search'];
		    $mypostids = $wpdb->get_col("select ID from $wpdb->posts where post_title LIKE '%$search%' ");
 			}
 			else
 			{
		    $mypostids = $wpdb->get_col("select ID from $wpdb->posts");
		   }
		    

		   if($mypostids){
 				 $args = array(
		        'post__in'=> $mypostids,
		        'post_type'=>'post',
		        'orderby'=>'title',
		        'order'=>'asc' ,
		         'cat' => 4   
		    );
 			}else{ $args = array();echo "No result found.";}

		    $res = new WP_Query($args);
		     while( $res->have_posts() ) : $res->the_post();

		       // echo get_the_title($post->ID)."</br>";


		   ?>
					
						
						<li>
							<div class="tab-heading"><h3><?php echo get_the_title($post->ID); ?></h3><a href="javascript:void(0);"><i class="fa fa-plus" id="iconId"></i></a></div>
							<div class="description">
								<?php echo get_the_content($post->ID); ?>
							</div>
						</li>
					<?php  endwhile;
					wp_reset_postdata();?>
	           </ul>
          </div>	



		</div>		
	</div>
</section>


<?php 

get_footer();
?>
<script type="text/javascript">
	 $(document).ready(function(){
 
     $('.tab-heading').on('click',function(){
          $(this).next().slideToggle(700);
          $(this).find('#iconId').toggleClass('fa-minus');
         
    });
     
  });
</script>
