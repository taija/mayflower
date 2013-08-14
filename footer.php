	</div><!-- #main .container -->
</div><!-- #main-wrap -->

		<?php 
		global $globals_path, $globals_path_over_http, $mayflower_version, $mayflower_brand;
		//echo " Globals Path: " . $globals_path . ". HTTP Path: " . $globals_path_over_http;
		if( $mayflower_brand == 'lite') {
			bc_footer_legal();
		} else {
			bc_footer();
		}
		?>
        
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo $globals_path_over_http; ?>j/bootstrap.min.js"></script>
<script src="<?php echo $globals_path_over_http; ?>j/g.js"></script>
<?php wp_footer(); ?>

<!-- <?php
$mayflower_version = wp_get_theme();
echo $mayflower_version->Name . " version " . $mayflower_version->Version;
?>  -->

</body>
</html>