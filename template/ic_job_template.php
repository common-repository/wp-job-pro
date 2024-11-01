<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php 
$gobalvar = icjm_gobal();
include_once($gobalvar["plugin_dir_path"]."ic-custom-post-type.php");
$obj = new icjm_custom_post_type();
//$obj->print_array($_REQUEST);
?>
<?php get_header(); ?>
<?php get_footer(); ?>