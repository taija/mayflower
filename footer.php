<?php
global $mayflower_brand;
if ( $mayflower_brand == 'lite' ) {
	get_template_part( 'part-flexnav' );
} else { }
?>
			</div><!-- row -->
		</div><!-- col-md-12 -->
	</div><!-- #main .container -->
</div><!-- #main-wrap -->

<?php

if ( $mayflower_brand == 'lite' ) {
	bc_footer_legal();
} else if ( is_multisite_home() ){
	bc_home_footer();
} else {
	bc_footer();
}
wp_footer();
?>

<!-- <?php
$mayflower_version = wp_get_theme();
echo $mayflower_version->Name . " version " . $mayflower_version->Version;
?>  -->

</body>
</html>
