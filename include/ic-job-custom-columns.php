<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! class_exists( 'icjm_job_custom_columns' ) ) { 
	include_once("ic-job-function.php");
	class icjm_job_custom_columns  extends icjm_job_function{
		public function __construct(){}
		
		function get_job_custom_columns($columns){
			unset( $columns['date'] );
			$columns['_icjm_job_status_label'] 		  = __( 'Status', 		'icjm_job' );
			$columns['_icjm_job_category_label'] 		= __( 'Category', 		'icjm_job' );
			$columns['_icjm_job_location_label'] 		= __( 'Location', 		'icjm_job' );
			$columns['_icjm_job_type_label'] 			= __( 'Type', 			'icjm_job' );
			$columns['_icjm_job_position_label'] 		= __( 'Position', 		'icjm_job' );
			$columns['_icjm_job_company_label'] 		 = __( 'Company', 		'icjm_job' );
			$columns['date'] 						    = __( 'Created Date', 	'icjm_job' );
			return $columns;
		}
		
		function get_job_custom_value($column, $post_id){
			switch($column){
				case "_icjm_job_status_label":
					//echo get_post_meta( $post_id , '_icjm_job_location_label', true );
					echo	 $this->icjm_get_post_meta($post_id, array('_icjm_job_status_label'),"VAR");
					break;
				case "_icjm_job_category_label":
					//echo get_post_meta( $post_id , '_icjm_job_category_label', true );
					echo	 $this->icjm_get_post_meta($post_id, array('_icjm_job_category_label'),"VAR");
					break;
				case "_icjm_job_location_label":
					//echo get_post_meta( $post_id , '_icjm_job_location_label', true );
					echo	 $this->icjm_get_post_meta($post_id, array('_icjm_job_location_label'),"VAR");
					break;
				case "_icjm_job_type_label":
					//echo get_post_meta( $post_id , '_icjm_job_type_label', true );
					echo	 $this->icjm_get_post_meta($post_id, array('_icjm_job_type_label'),"VAR");
					break;	
				case "_icjm_job_position_label":
					//echo get_post_meta( $post_id , '_icjm_job_position_label', true );
					echo	 $this->icjm_get_post_meta($post_id, array('_icjm_job_position_label'),"VAR");
					break;	
				case "_icjm_job_company_label":
					//echo get_post_meta( $post_id , '_icjm_job_company_label', true );
					echo	 $this->icjm_get_post_meta($post_id, array('_icjm_job_company_label'),"VAR");
					break;					
				default:
					//echo "Test";
			}
		}
	}
}
?>