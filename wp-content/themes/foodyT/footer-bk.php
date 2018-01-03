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
				<div class=" col-md-4 col-sm-4 col-xs-12 left-part social-links">
					<?php dynamic_sidebar('social-list'); ?>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12 middle-part">
					<?php dynamic_sidebar('copyright'); ?>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12 right-part">
					<?php
						wp_nav_menu(array('theme_location'=>'footer', 'menu_class'=>'footer-menu', 'menu_id'=>'footer_menu'));
					?>
				</div>
			</div>
			</div>
		</footer>
	</div><!-- .site-content-contain -->
</div>
<?php wp_footer(); ?>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/custom.js"></script>
<div id="google_translate_element" style="display: none;">
</div>
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
</script>
</body>
</html>
