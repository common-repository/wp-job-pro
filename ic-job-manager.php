<?php 
/**
Plugin Name: WP job Pro
Description: Job Manager Pro plugin to manage your organization's hiring process.
Version: 2.0
Author: Infosoft Consultants
Author URI: http://plugins.infosofttech.com
Plugin URI: https://wordpress.org/plugins/wp-job-pro/

Tested Wordpress Version: 6.1.x
WC requires at least: 3.5.x
WC tested up to: 7.4.x
Requires at least: 5.7
Requires PHP: 5.6

Text Domain: icjm_job
Domain Path: /languages/
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! class_exists( 'icjm_job_manager' ) ) { 
	class icjm_job_manager{
		
		function __construct() {
			add_filter( 'plugin_action_links_wp-job-pro/ic-job-manager.php', array( $this, 'plugin_action_links' ), 9, 2 );
			add_action( 'init', array( $this, 'load_plugin_textdomain' ));
			add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ));
		}
		
		function plugins_loaded(){
			include_once("include/ic-job-init.php");
			global $constants; 
			//$constants = array('path'=>__FILE__);
			$constants ["menu_name"]  = "edit.php?post_type=icjm_job";
			$constants ["plugin_dir_path"]  = plugin_dir_path(__FILE__);
			$constants ["path"] = __FILE__;
			//$constants ["menu_name"]  = "icjm_job";
			$obj =new  icjm_job_init($constants);
		}
		
		function plugin_action_links($plugin_links, $file = ''){
			$plugin_links[] = '<a target="_blank" href="'.admin_url('edit.php?post_type=icjm_job').'">' . esc_html__( 'Jobs', 'icjm_job' ) . '</a>';
			return $plugin_links;
		}
		
		function load_plugin_textdomain(){
			load_plugin_textdomain( 'icjm_job', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
		}
	}
	$obj = new  icjm_job_manager();
}
?>