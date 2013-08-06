	</div><!-- #main .container -->
</div><!-- #main-wrap -->

		<?php 
		Global $mayflowerVersion;
		//echo "Version + " . $mayflowerVersion;
		if( $mayflowerVersion == 'lite') {
			bc_footer_legal();
		} else {
			bc_footer();
		}
		?>
        
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/bootstrap.min.js"></script>
<?php wp_footer(); ?>

<?php
// Get Mayflower version number from Mayflower network settings
	$network_mayflower_settings = get_site_option( 'mayflower_network_mayflower_settings' );
 	$mayflower_version = $network_mayflower_settings['mayflower_version']; 
?>
<!-- Mayflower Version: <?php echo $mayflower_version; ?> -->
</body>
</html>