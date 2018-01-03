<?php
/*
Template Name:Home page
*/


get_header();?>


<section id="home" class="home fheight" style="background:url(<?php echo get_template_directory_uri(); ?>/assets/images/home-banner.jpg) no-repeat; background-position:center center; background-size:cover">
	<div class="inner-cell">
		<div class="container"> 
		
		<div class="row">
			<div class="col-md-12 headings text-center">
				<!-- <h2>Find Y<span></span>ur <span class="bold">Restaurant Digital</span> Menu</h2> -->
				<?php 
				if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es')
				 echo get_post_meta(164,'title',true); 
				else
				 echo get_post_meta(164,'title_english',true); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center">
				<ul class="icons">
					<li class="plane  active" iconName='location' placeHolder='<?= $_SESSION['lan']['home']['location']?>'><a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?= $_SESSION['lan']['home']['location']?>"></a>
					</li>

					<li class="edit " iconName='restaurantName' placeHolder='<?= $_SESSION['lan']['home']['name']?>'><a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?= $_SESSION['lan']['home']['name']?>"></a>
                    </li>
					
					<li class="curtely " iconName='cuisine' placeHolder='<?= $_SESSION['lan']['home']['cuisine']?>'><a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?= $_SESSION['lan']['home']['cuisine']?>"></a>
					</li>

				</ul>
				
				<div class="search">
					<span class="fa fa-search"></span>
					<form action='<?php  echo get_the_permalink(497);?>' method='get'>
						<input type="search"  id='searchHomePage' name='location' placeholder="<?= $_SESSION['lan']['home']['location']?>" required="true">
						<input type="submit" style="display:none;">
					</form>
					
				</div>
			</div>
			</div>
		</div>		
	</div>
	</div>
</section>
<section id="home-middle-part">
  <?php if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es')
	{ ?>
		<div class="container">
		<div class="row">
			<h1>¿Cómo funciona Foodyt, tu carta digital?</h1>
		</div>
		<div class="left">
			<?php dynamic_sidebar('for-the-diner-spanish'); ?>			
		</div>
		<div class="right">
			<?php dynamic_sidebar('For-the-restaurant-spanish');?>			
		</div>
	</div>
	<?php }
	else
	{ ?>
		<div class="container">
		<div class="row">
			<h1>How does Foodyt work?</h1>
		</div>
		<div class="left">
			<?php dynamic_sidebar('for-the-diner-english'); ?>			
		</div>
		<div class="right">
			<?php dynamic_sidebar('For-the-restaurant-english');?>			
		</div>
	</div>
	<?php }
	?>
	
</section>

 

<?php get_footer();
?>
<!-- <script type="text/javascript">
	var jqHome = $.noConflict(); 
	jqHome(document).ready(function(){
		    // jqHome('[data-toggle="tooltip"]').tooltip();  
		    jqHome('.icons li').click(function(){
			jqHome('.icons li').removeClass('active');
			jqHome(this).addClass('active');
			var iconName = jqHome(this).attr('iconName');
			var placeHolder = jqHome(this).attr('placeHolder');
			jqHome('#searchHomePage').attr('name',iconName);
			jqHome('#searchHomePage').attr('placeholder',placeHolder);
		});
	});
</script> -->
