<?php 
global $mayflower_brand;
if( $mayflower_brand == 'lite') {
	get_template_part('part-flexnav');
} else {
}
?>
			</div><!-- row -->
		</div><!-- col-md-12 -->

	</div><!-- #main .container -->
</div><!-- #main-wrap -->

<?php 
?>

<?php 
global $globals_path, $globals_path_over_http, $mayflower_version, $mayflower_brand;
if( $mayflower_brand == 'lite') {
	//get_template_part('part-flexnav');
	bc_footer_legal();
} else {
	bc_footer();
}
?>

<script src="<?php echo $globals_path_over_http; ?>j/bootstrap.min.js"></script>
<script src="<?php echo $globals_path_over_http; ?>j/g.js"></script>
<?php


wp_footer(); 
?>

<!-- <?php
$mayflower_version = wp_get_theme();
echo $mayflower_version->Name . " version " . $mayflower_version->Version;
?>  -->

</body>
</html>