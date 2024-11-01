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
	<div id="content">
    	<form id="frm_job_search" name="frm_job_search" method="post">
    		<table>
            	<tr>
                	<td>Status</td>
                    <td>Category</td>
                    <td>Location</td>
                    <td>Type</td>
                    <td>Position</td>
                    <td></td>
                </tr>
            	<tr>
                	<td><?php $obj->get_post_type_dropdown("icjm_job_status","-1"); ?></td>
                    <td><?php $obj->get_post_type_dropdown("icjm_job_category","-1"); ?></td>
                    <td><?php $obj->get_post_type_dropdown("icjm_job_location","-1"); ?></td>
                    <td><?php $obj->get_post_type_dropdown("icjm_job_type","-1"); ?></td>
                    <td><?php $obj->get_post_type_dropdown("icjm_job_position","-1"); ?></td>
                    <td><input type="submit" /></td>
                </tr>
            </table>
            <input type="hidden" name="action" 		id="action" 	value="icjm_job_ajax_request" />
    		<input type="hidden" name="sub_action" 	id="sub_action" value="icjm_job" />
            <input type="hidden"  name="perPage" id="perPage" value="4"/>
            <input type="hidden"  name="p" id="p" value="1"  />
    	</form>
		<div class="ajax_content"></div>
   </div>
<?php get_footer(); ?>