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
<script src="<?php bloginfo('template_directory'); ?>/js/bootstrap.min.js"></script>
<?php wp_footer(); ?>

</body>
</html>