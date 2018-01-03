<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
</div><!-- #content -->
<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="container">
		<div class="wrap">
			<div class="left-part social-links">
				<?php dynamic_sidebar('social-list'); ?>
			</div>
			<div class="middle-part">
				<?php if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es'){  dynamic_sidebar('copyright_spanish'); }else{dynamic_sidebar('copyright_english');}?>
			</div>
			<div class="right-part">
				<?php
					if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es'){ wp_nav_menu(array('theme_location'=>'footer', 'menu_class'=>'footer-menu', 'menu_id'=>'footer_menu'));}
					else{
						wp_nav_menu(array('theme_location'=>'footer-menu-english', 'menu_class'=>'footer-menu', 'menu_id'=>'footer_menu'));
					}
				?>
			</div>
		</div>
	</div>
</footer>
</div><!-- .site-content-contain -->
</div>
<?php wp_footer(); ?>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/custom.js"></script>
	<script>
		$(function () {
			$('#my-welcome-message').firstVisitPopup({
				cookieName : 'homepage'
				//showAgainSelector: '#show-message'
			});
		});
		
		jQuery(document).ready(function () {

		      jQuery('.close,body').click(function () {
			  jQuery('#beconModal').hide();
			  jQuery('#beconModal iframe').attr("src", jQuery("#beconModal iframe").attr("src"));
			});

		});
	</script>


</body>
</html>
