<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! class_exists( 'icjm_job_init' ) ) { 
	include_once("ic-job-function.php");
	class icjm_job_init extends  icjm_job_function{
		var $constants = array();
		public function __construct($constants = array()){
		
			
			$this->constants = $constants;
			
			add_action( 'init', array(&$this,'init') );
			add_action( 'wp', 	array(&$this,'icjm_wp')   );
			add_action( 'admin_enqueue_scripts',  array(&$this,'admin_enqueue_scripts' ));
			
			add_action('admin_menu', array(&$this,'admin_menu'));
			
			add_action( 'add_meta_boxes',  array(&$this,'icjm_add_job_metaboxes') );
			add_action( 'save_post', array( &$this, 'icjm_save_post'), 10, 2 );
			
			//add_filter( 'cmb_meta_boxes',  array( &$this,'be_sample_metaboxes2' ));
			
			
		
			
			//add_action( 'plugins_loaded',  array( &$this, 'plugins_loaded' ) );
		
			add_action( 'wp_ajax_icjm_job_ajax_request',  array(&$this,'icjm_job_ajax_request' ));
			add_action( 'wp_ajax_nopriv_icjm_job_ajax_request',  array(&$this,'icjm_job_ajax_request' ));
			
			
			
			/*For Custom Columns for job Post Type*/
			add_filter( 'manage_icjm_job_posts_columns', array(&$this,'icjm_set_custom_edit_job_columns') );
			add_action( 'manage_icjm_job_posts_custom_column' ,  array(&$this,'icjm_custom_job_column'), 10, 2 );
			
		
			
			add_action('admin_init', array( &$this, 'admin_init' ) );
			add_action('admin_footer', array( &$this, 'admin_footer'));
			
			/*Chnage Feature Image Title to Compnay Log*/
			add_action('do_meta_boxes',  array(&$this,'icjm_be_rotator_image_metabox') );
			
			
			add_shortcode( 'list-icjm-job', array(&$this,'icjm_show_filter' ));
			
			add_action( 'wp_enqueue_scripts',  array(&$this,'icjm_my_styles_method') );
			
			
			add_filter( 'the_content', array( $this, 'icjm_job_content' ) );
			
		}
		
		function icjm_job_content($content){
			global $post;

			if ( ! is_singular( 'icjm_job' ) || ! in_the_loop() || 'icjm_job' !== $post->post_type ) {
				return $content;
			}
			ob_start();
			$this->icjm_show_job_details($post);
			$output = ob_get_clean();
			return $output;
		}
		
		function icjm_show_job_details($post){
			 $post_id=  $post->ID;
			?>
			<div class="icjm_job_details">
            	<div class="custom-search">
					<div class="search-heading">
						<h4>Job Details</h4>
					</div>
					
					<div class="content">
						<div class="job_details_content">
							<strong>Status: </strong>
							<span><?php echo get_post_meta($post_id, '_icjm_job_status_label',true); ?></span>
						</div>
						
						<div class="job_details_content">
							<strong>Category: </strong>
							<span><?php echo get_post_meta($post_id, '_icjm_job_category_label',true); ?></span>
						</div>
						
						<div class="job_details_content">
							<strong>Location: </strong>
							<span><?php echo get_post_meta($post_id, '_icjm_job_location_label',true); ?></span>
						</div>
						
						<div class="job_details_content">
							<strong>Type: </strong>
							<span><?php echo get_post_meta($post_id, '_icjm_job_type_label',true); ?></span>
						</div>
						
						<div class="job_details_content">
							<strong>Position: </strong>
							<span><?php echo get_post_meta($post_id, '_icjm_job_position_label',true); ?></span>
						</div>
						
						<div class="job_details_content">
							<strong>Company: </strong>
							<span><?php echo get_post_meta($post_id, '_icjm_job_company_label',true); ?></span>
						</div>
					</div>
				</div>
				
				<div class="icjm_submit_btn apply">
					<input type="button" value="Apply" data-popup-open="popup-1" class="icjm_btn" />
				</div>
	 
				<div class="popup" data-popup="popup-1">
					<div class="popup-inner">
						<h3>Apply for Job</h3>
						<form id="frm_job_apply" name="frm_job_apply" method="post">
							<div class="icjm_application_message alert"></div>
							
							<div class="form">
								<div class="form-group">
									<label>First Name:</label>
									<div class="input_box">
										<input type="text" name="first_name" id="first_name" class="control-label" />
									</div>
								</div>
								
								<div class="form-group">
									<label>Last Name:</label>
									<div class="input_box">
										<input type="text" name="last_name" id="last_name" class="control-label" />
									</div>
								</div>
								
								<div class="form-group">
									<label>Email Address:</label>
									<div class="input_box">
										<input type="text" name="email_address" id="email_address" class="control-label" />
									</div>
								</div>
								
								<div class="form-group">
									<label>Contact no:</label>
									<div class="input_box">
										<input type="text" name="contact_no" id="contact_no" class="control-label" />
									</div>
								</div>
								
								<div class="form-group">
									<label>About yourself:</label>
									<div class="input_box">
										<textarea id="about_yourself" name="about_yourself" class="control-label"></textarea>
									</div>
								</div>
							</div>
	
							<div>
								<div class="icjm_submit_btn">
									<input type="button" value="Apply" id="btnApply" class="icjm_btn" />
									<input type="button" data-popup-close="popup-1" value="Close" class="icjm_btn" />
									
									<input type="hidden" name="action" id="action" value="icjm_job_ajax_request" />
									<input type="hidden" name="sub_action" id="sub_action" value="icjm_apply_job" />
									<input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id; ?>" />
								</div>
							</div>
						</form>
						<a class="popup-close" data-popup-close="popup-1" href="#"></a>
					</div>
				</div>
			</div>
            <?php
			//print("<pre>".print_r($post,true)."</pre>");
		}
		
		function icjm_my_styles_method(){
			wp_enqueue_style('ic-job-front-style', plugins_url( '../css/fornt-end.css', __FILE__ ));
		}
		/*
		function rmcc_post_listing_shortcode1( $atts ) {
			ob_start();
			$query = new WP_Query( array(
				'post_type' => 'icjm_job',
				'color' => 'blue',
				'posts_per_page' => -1,
				'order' => 'ASC',
				'orderby' => 'title',
			) );
			if ( $query->have_posts() ) { ?>
				<ul class="clothes-listing">
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</li>
					<?php endwhile;
					wp_reset_postdata(); ?>
				</ul>
			<?php $myvariable = ob_get_clean();
			return $myvariable;
			}
		}
		*/
		function icjm_show_filter(){
			$gobalvar = icjm_gobal();
			include_once($gobalvar["plugin_dir_path"]."ic-custom-post-type.php");
			$obj = new icjm_custom_post_type();

			?>
            
            <div class="icjm_custom_search">
                <!--<div class="search-heading">Search</div>-->
                <form id="frm_job_search" name="frm_job_search" method="post">
                	<div class="icjm_row">
                        <div class="icjm_formrow">
                            <div class="icjm_label_text"><label>Status</label></div>
                            <div class="icjm_select_text">
                                <?php $obj->get_post_type_dropdown("icjm_job_status","-1"); ?>
                            </div>
                        </div>
                        
                        <div class="icjm_formrow">
                            <div class="icjm_label_text"><label>Category</label></div>
                            <div class="icjm_select_text">
                                <?php $obj->get_post_type_dropdown("icjm_job_category","-1"); ?>
                            </div>
                        </div>
                        
                        <div class="icjm_formrow">
                            <div class="icjm_label_text"><label>Location</label></div>
                            <div class="icjm_select_text">
                                <?php $obj->get_post_type_dropdown("icjm_job_location","-1"); ?>
                            </div>
                        </div>
                        
                        <div class="icjm_formrow">
                            <div class="icjm_label_text"><label>Type</label></div>
                            <div class="icjm_select_text">
                            	<?php $obj->get_post_type_dropdown("icjm_job_type","-1"); ?>
                            </div>
                        </div>
                        
                        <div class="icjm_formrow">
                            <div class="icjm_label_text"><label>Position</label></div>
                            <div class="icjm_select_text">
                                <?php $obj->get_post_type_dropdown("icjm_job_position","-1"); ?>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    <div class="icjm_submit_btn"><input type="submit" value="Search" class="icjm_btn" /></div>
                    
                    <input type="hidden" name="action" id="action" value="icjm_job_ajax_request" />
                    <input type="hidden" name="sub_action" id="sub_action" value="icjm_job" />
                    <input type="hidden" name="perPage" id="perPage" value="4"/>
                    <input type="hidden" name="p" id="p" value="1" />
                </form>
            </div>
            <div class="clearfix"></div>
            
            <div class="icjm_job_front_section">
                <div class="ajax_content"></div>
            </div>
            <?php	
		}
		
		/*
		function rmcc_post_listing_shortcode2( $atts ) {
			ob_start();
			$query = new WP_Query( array(
				'post_type' => 'icjm_job',
				'color' => 'blue',
				'posts_per_page' => -1,
				'order' => 'ASC',
				'orderby' => 'title',
			) );
			if ( $query->have_posts() ) { ?>
				<ul class="clothes-listing">
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</li>
					<?php endwhile;
					wp_reset_postdata(); ?>
				</ul>
			<?php $myvariable = ob_get_clean();
			return $myvariable;
			}
		}
		*/
		// Show posts of 'post', 'page' and 'movie' post types on home page
		function icjm_be_rotator_image_metabox() {
			remove_meta_box('postimagediv', 'icjm_job_company', 'side' );
			add_meta_box('postimagediv', __('Company Logo'), 'post_thumbnail_meta_box', 'icjm_job_company', 'normal', 'high');
		}
		/*
		function portfolio_page_template($template){
				//global $post;
				//$this->print_array($_REQUEST);
				//$this->print_array($post);
				//die;	
			
		}
		*/
		function admin_init(){
			if(isset($_REQUEST['btn_excel_export'])){
				$today = date_i18n("Y-m-d-H-i-s");				
				$FileName = "order-list"."-".$today.".xls";	
				
				include_once("ic-job-report.php");
				$obj = new icjm_job_report();
				$obj->export_job($FileName,"xls");
				die;
			}	
		}
		
		function icjm_set_custom_edit_job_columns($columns){
			include("ic-job-custom-columns.php");
			$obj =  new  icjm_job_custom_columns();
			$columns  = $obj->get_job_custom_columns($columns);	
			return $columns;
		}
		
		function icjm_custom_job_column($column, $post_id ){
			include("ic-job-custom-columns.php");
			$obj =  new  icjm_job_custom_columns();
			$obj->get_job_custom_value($column, $post_id );	
		}
		
		function icjm_add_current_nav_class($classes, $item) {
		
			// Getting the current post details
			global $post;
			
			// Getting the post type of the current post
			$current_post_type = get_post_type_object(get_post_type($post->ID));
			
			$current_post_type_slug = $current_post_type->rewrite[slug];
			// Getting the URL of the menu item
			$menu_slug = strtolower(trim($item->url));
			// If the menu item URL contains the current post types slug add the current-menu-item class
			if (strpos($menu_slug,$current_post_type_slug) !== false) {
			   $classes[] = 'current-menu-item';
			}
			// Return the corrected set of classes to be added to the menu item
			return $classes;
		
		}
		
		function add_page(){
		 	if (isset($_REQUEST["page"])){
				$page = $_REQUEST["page"];
				$post_type = $_REQUEST["post_type"];
				if ($page =="ic-job-report" && $post_type=="icjm_job" ){
					include_once("ic-job-report.php");
					$obj = new icjm_job_report($this->constants);
					$obj->init();
				}
				if ($page =="ic-job-application" && $post_type=="icjm_job" ){
					include_once("ic-job-application-list.php");
					$obj = new  icjm_job_application_list();
					//$obj->init();
					$obj->display_job_application();
				}
				if ($page =="icjm_add_ons_page" && $post_type=="icjm_job" ){
					include_once("ic_job_add_ons.php");
					$obj = new  ic_job_addons($this->constants);
					$obj->init();
					
				}
			}
			
		}
		
		function icjm_job_ajax_request(){
			//echo json_encode($_REQUEST);
			//die;
			//do_action("ni_enquiry_form_data",$_REQUEST);
			$sub_action =  isset($_REQUEST["sub_action"])?$_REQUEST["sub_action"] : '';
			switch ($sub_action) {
				case "icjm_job":
					include_once("ic-custom-post-type.php");
					$obj = new icjm_custom_post_type();
					$obj->ajax();
					break;
				case "icjm_job_backend":	
					//echo "Anzar";
					include_once("ic-job-report.php");
					$obj = new icjm_job_report();
					$obj->ajax();
					break;
				case "icjm_apply_job":
					include_once("ic-save-job-application.php");
					$obj = new icjm_save_job_application();
					$obj->icjm_save_job();
					break;
				case "icjm_add_ons_page":
					include_once("ic_job_add_ons.php");
					$obj = new ic_job_addons();
					$obj->init();
					break;	
				default:
					break;
			}
			//echo json_encode($_REQUEST);
			die;
		}
		
		function plugins_loaded(){
			//include_once("ic-page-templater.php");
			//$obj  = new  PageTemplater($this->constants['path']);
			
		}
		
		function icjm_wp(){
			global $post;
			//echo $post->ID;
			//echo  get_post_meta($post->ID, '_wp_page_template', true );
			//$this->print_array($post);
			//echo "dsad";
			
			//die;
			//echo "sam123";
			
			if(!isset($post->ID)){
				return false;
			}
			
			$template_name=get_post_meta($post->ID, '_wp_page_template', true );
			if ($template_name=="icjm_job_template.php"){
				/*Add CSS For Front End*/
				wp_enqueue_style('ic-front-end-style',  plugins_url( '../css/style.css', __FILE__ ));
				wp_enqueue_style('ic-front-end-bootstrap-style',  plugins_url( '../css/lib/bootstrap.css', __FILE__ ));
				wp_enqueue_style('ic-front-end-font-awesome-style',  plugins_url( '../css/lib/font-awesome.css', __FILE__ ));
			}
		}
		
		/*Create and Register Post Type*/
		function init(){
			global $post;
			//$this->print_array($post);
			//die;
			//echo "sam123";
			include_once("ic-custom-post-type.php");
			$obj =  new icjm_custom_post_type();
			$obj->icjm_create_custom_post("icjm_job","Job", "Jobs",array('title', 'editor'),true);
			//$obj->icjm_create_custom_post("icjm_job","Job", "Jobs",array('title', 'editor'),								$this->constants["menu_name"]);
			$obj->icjm_create_custom_post("icjm_job_status","Status", "Status",array('title', 'editor'),					$this->constants["menu_name"]);
			$obj->icjm_create_custom_post("icjm_job_category","Category", "Categories",array('title', 'editor'),			$this->constants["menu_name"]);	
			$obj->icjm_create_custom_post("icjm_job_location","Location", "Locations",array('title', 'editor'),				$this->constants["menu_name"]);
			$obj->icjm_create_custom_post("icjm_job_type","Type", "Types",array('title', 'editor'),							$this->constants["menu_name"]);	
			$obj->icjm_create_custom_post("icjm_job_position","Position", "Positions",array('title', 'editor'),				$this->constants["menu_name"]);
			$obj->icjm_create_custom_post("icjm_job_company","Company", "Companies",array('title', 'editor','thumbnail'),	$this->constants["menu_name"]);
			
			wp_enqueue_script( 'ic-job-ajax-script', plugins_url( '../js/script.js', __FILE__ ), array('jquery') );	
			wp_localize_script( 'ic-job-ajax-script', 'icjm_job_ajax_object', array( 'icjm_job_ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234, 'admin_url' => admin_url("admin.php"), 'admin_page'=>(isset($_REQUEST["page"]) ? $_REQUEST["page"] : '') ) );
		
			wp_enqueue_script( 'ic-job-script-front-end', plugins_url( '../js/ic-job-front-end.js', __FILE__ ) , array( 'jquery' ) );	
			
		
		}
		
		/*admin_enqueue_scripts*/
		function admin_enqueue_scripts($hook){
			//print_r($hook);
			//die;
			
			wp_enqueue_script('jquery-ui-datepicker');	
			wp_enqueue_script( 'ic-job-script', plugins_url( '../js/ic-job.js', __FILE__ ) , array( 'jquery' ) );
			wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css');
			
			/*Color Picker*/
		 	wp_enqueue_style( 'wp-color-picker' ); 
			wp_enqueue_script( 'wp-color-picker');
			
			if (isset($_REQUEST["page"])){
				if ($_REQUEST["page"]=="ic-job-report"){
					wp_enqueue_style('ic-job-backend-style', plugins_url( '../css/ic-job-backend-style.css', __FILE__ ));
				}
			}
			
			if (isset($_REQUEST["page"])){
				if ($_REQUEST["page"]=="icjm_add_ons_page"){
					wp_enqueue_style('ic-job-backend-style', plugins_url( '../css/ic-job-backend-style.css', __FILE__ ));
				}
			}
			
			//wp_enqueue_style('ic-job-front-style', plugins_url( '../css/fornt-end.css', __FILE__ ));
			
			
		}
		
		/*Add Job Meta Box */
		function icjm_add_job_metaboxes(){
			include_once("ic-custom-post-type.php");
			$obj =  new icjm_custom_post_type();
			$obj->add_metabox();
			//$obj->add_metabox("custom_order_status_meta_box3","My Dynamic", 'ni_display_custom_order_status_meta_box', "icjm_job","normal", "high");
		}
		
		/*Save Post*/
		function icjm_save_post($ID, $post){
			include_once("ic-custom-post-type.php");
			$obj =  new icjm_custom_post_type();
			$obj->save_post($ID, $post);
			
			
		}
		/*End Save*/
		
		/*End and Register Post Type*/
		function admin_menu(){
			global $submenu;
			
			//print_r($submenu);
			unset($submenu['edit.php?post_type=icjm_job'][10]);
			// Hide link on listing page
			
			add_submenu_page( $this->constants["menu_name"], 'Report', 'Report','manage_options','ic-job-report',  array(&$this,'add_page'));
			add_submenu_page( $this->constants["menu_name"], 'Application', 'Application','manage_options','ic-job-application',  array(&$this,'add_page'));
			
			add_submenu_page( $this->constants["menu_name"], 'Other Plug-ins', 'Other Plug-ins','manage_options','icjm_add_ons_page',  array(&$this,'add_page'));
		}
		
		function admin_footer(){
			
			if (isset($_GET['post_type']) && $_GET['post_type'] == 'icjm_job') {
			?>	
					<style type="text/css">
						#favorite-actions, .add-new-h2 { display:none; }
					</style>;
             <?php       
			}
			
		}
		
		/*Template */
		function include_template_function($template_path ){
			 if ( get_post_type() == 'icjm_job' ) {
				if ( is_single() ) {
					// checks if the file exists in the theme first,
					// otherwise serve the file from the plugin
					if ( $theme_file = locate_template( array ( 'single-icjm_job.php' ) ) ) {
						$template_path = $theme_file;
					} else {
						$template_path = $this->constants ["plugin_dir_path"] .'template/single-icjm_job.php';
					}
				}
			}
			//echo $template_path;
			//die;
			return $template_path;
		}
	}
}
if ( ! function_exists( 'icjm_gobal' ) ) { 
function icjm_gobal(){
		
		//global $constants; 
		//echo plugin_dir_path(__FILE__);
		//print_r($constants);
		 $constants["plugin_dir_path"] = plugin_dir_path(__FILE__);
		 $constants["__FILE__"] = __FILE__;
		 //print_r($constants);
		 return $constants;
	}
}
?>