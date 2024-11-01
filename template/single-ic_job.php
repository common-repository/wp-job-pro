<?php get_header(); ?>
<?php
global $post;
//print_r($post);
//echo $post->ID;
$gobalvar = icjm_gobal();
include_once($gobalvar["plugin_dir_path"]."ic-custom-post-type.php");
$obj = new icjm_custom_post_type();
//$t =  array('_icjm_job_category_label');
$post_meta_columns =  array();
$post_meta_columns[] ="_icjm_job_category_label"; 
$post_meta_columns[] ="_icjm_job_location_label"; 
$post_meta_columns[] ="_icjm_job_status_label"; 
$post_meta_columns[] ="_icjm_job_type_label"; 
$post_meta_columns[] ="_icjm_job_position_label"; 
$post_meta_columns[] ="_icjm_job_company_label";
$post_meta_columns[] ="_icjm_job_company_id"; 

$get_post_meta = $obj->icjm_get_post_meta($post->ID,$post_meta_columns);
print_r($get_post_meta);
$new_post_meta = array();
foreach($get_post_meta  as $key=>$value){
	//echo $value->meta_value;
	//echo "<br>";
	//echo $value->meta_key;
	
	$new_post_meta[$value->meta_key] =  $value->meta_value;
}
//$obj->print_array ($new_post_meta);
//echo $new_post_meta["_icjm_job_location_label"];
/*
if(isset($_REQUEST["action"])){
	if ($_REQUEST["action"] =="apply" ){
		echo $_REQUEST["action"];
	}
	if ($_REQUEST["action"] =="view" ){
		echo $_REQUEST["action"];
	}
}
*/
?>
<?php get_footer(); ?>