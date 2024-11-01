<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! class_exists( 'icjm_custom_post_type' ) ) { 
	include_once("ic-job-function.php");
	class icjm_custom_post_type  extends icjm_job_function{ 
		function testfiled(){
			$test  = array();
			
			$test[] = array(
                'name' => __('Social Settings', 'galaxyfunder'),
                'type' => 'title',
                'desc' => __('Here you can customize social settings', 'galaxyfunder'),
                'id' => '_crowdfunding_social_settings'
            );
			
			$test[] = array(
                'name' => __('Social Settings', 'galaxyfunder'),
                'type' => 'title',
                'desc' => __('Here you can customize social settings', 'galaxyfunder'),
                'id' => '_crowdfunding_social_settings'
            );
			
			$test[] = array(
                'name' 		=> __('Goal Label', 'galaxyfunder'),
                'desc' 		=> __('Please Enter Goal Label for Campaign', 'galaxyfunder'),
                'tip' 		=> '',
                'css' 		=> 'min-width:550px;',
                'id' 		=> 'crowdfunding_target_price_tab_product',
                'std' 		=> 'Goal',
                'type' 		=> 'text',
                'newids' 	=> 'crowdfunding_target_price_tab_product',
                'desc_tip' 	=> true,
            );
			
			$test2 = array();
			
			$test2["name"]=  __('Social Settings', 'galaxyfunder'); 
			$test2["type"]=  "title"; 
			$test2["desc"]=  __('Here you can customize social settings', 'galaxyfunder');
			$test2["id"]=  '_crowdfunding_social_settings';
			
			$test[] = $test2 ; 
					
			return $test;
		}
		
		function icjm_get_meta_box(){
			$meta_box =array();
			
			$meta_box["icjm_job_details"]["id"] 			= "icjm_job_details";	
			$meta_box["icjm_job_details"]["title"] 		= "Job Details";	
			$meta_box["icjm_job_details"]["callback"] 	= "icjm_display_job_meta_box";	
			$meta_box["icjm_job_details"]["post_type"] 	= "icjm_job";	
			$meta_box["icjm_job_details"]["context"] 		= "normal";	
			$meta_box["icjm_job_details"]["priority"] 	= "high";
			//$meta_box["icjm_job_details"]["fileds"] 		=  array(array("dsadsa","C"),array("E","F"));	
			
			$meta_box["icjm_company_details"]["id"] 			= "icjm_company_details";	
			$meta_box["icjm_company_details"]["title"] 		= "Company Details";	
			$meta_box["icjm_company_details"]["callback"] 	= "icjm_display_company_meta_box";	
			$meta_box["icjm_company_details"]["post_type"] 	= "icjm_job_company";	
			$meta_box["icjm_company_details"]["context"] 		= "normal";	
			$meta_box["icjm_company_details"]["priority"] 	= "high";
			
			
			$meta_box["icjm_status_details"]["id"] 			= "icjm_status_details";	
			$meta_box["icjm_status_details"]["title"] 		= "Status Details";	
			$meta_box["icjm_status_details"]["callback"] 	= "icjm_display_status_meta_box";	
			$meta_box["icjm_status_details"]["post_type"] 	= "icjm_job_status";	
			$meta_box["icjm_status_details"]["context"] 		= "normal";	
			$meta_box["icjm_status_details"]["priority"] 	= "high";	
			
			
			return $meta_box;
		}
		
		/*Create Custom Post Type*/
		function icjm_create_custom_post($post_type_name='', $singular='',$plural='', $supports = array('title', 'editor'),$show_in_menu = true){
			 $labels = array(
					'name'               => _x( $plural, 	'post type general name' ),
					'singular_name'      => _x( $singular,  'post type singular name' ),
					'add_new'            => _x( 'Add New ', 	 $singular ),
					'add_new_item'       => __( 'Add New '.$singular ),
					'edit_item'          => __( 'Edit '.$singular ),
					'new_item'           => __( 'New '.$singular ),
					//'all_items'          => __( 'All '. $plural ),
					'view_item'          => __( 'View '.$singular ),
					'search_items'       => __( 'Search '.$plural ),
					'not_found'          => __( 'No '. $plural.' found' ),
					'not_found_in_trash' => __( 'No '. $plural.' found in the Trash' ), 
					'parent_item_colon'  => '',
					'parent'             => __( 'Parent Job', 'woocommerce' ),
					
					'menu_name'          => _x( $plural, 'Admin menu name', 'woocommerce' )
					
				);
				$args = array(
					'labels'        => $labels,
					'description'   => 'Holds our '. $plural.' and '.$singular.' specific data',
					'public'              => true,
					'show_ui'             => true,
					'map_meta_cap'        => true,
					'publicly_queryable'  => true,
					'query_var' 		  => true,
					'rewrite' 			  => false,
					//plugins_url( '../js/ic-job.js', __FILE__ )
					'menu_icon' => plugins_url( '../images/icon.png', __FILE__ ), // 16px16
					//'menu_icon'			   =>'',	
					'capability_type' => 'post',
					//'show_ui' => true,
					'menu_position' => 22,
					//'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
					'supports'      => $supports,
					'has_archive'   => false,
					'show_in_menu'  => $show_in_menu ,
					//'capabilities'       => array( 'create_posts' => false ),       
					'map_meta_cap'        => true,
					
			  );
			  register_post_type( $post_type_name, $args ); 
		}
		
		function add_metabox(){
			$meta_box = 	$this->icjm_get_meta_box();
			foreach($meta_box  as $key=>$value){
				
				 $id 			= $value["id"];
				 $title 		= $value["title"];
				 $callback 		= $value["callback"];
				 $post_type 	= $value["post_type"];
				 $context 		= $value["context"];
				 $priority 		= $value["priority"];
				
				add_meta_box(
					$id , 
					$title,
					array( &$this,$callback),
					$post_type,
					$context,
					$priority
				);
			}
			//$this->print_array($meta_box );
				
		}
		
		function icjm_display_job_meta_box($post, $meta_box)
		{
			//$test123 = $this->testfiled();
			//$this->print_array($test123);
			//echo $meta_box["id"];
			// Retrieve current slug and color base on the post id
			$icjm_job_type = esc_html( get_post_meta( $post->ID, '_icjm_job_type_id', true ) );
			
			$icjm_job_category = esc_html( get_post_meta( $post->ID, '_icjm_job_category_id', true ) );
			
			$icjm_job_status = esc_html( get_post_meta( $post->ID, '_icjm_job_status_id', true ) );
			
			$icjm_job_location = esc_html( get_post_meta( $post->ID, '_icjm_job_location_id', true ) );
			
			$icjm_job_position = esc_html( get_post_meta( $post->ID, '_icjm_job_position_id', true ) );
			
			$icjm_job_company = esc_html( get_post_meta( $post->ID, '_icjm_job_company_id', true ) );
			
			$icjm_job_expired_date = esc_html( get_post_meta( $post->ID, '_icjm_job_expired_date', true ) );
			
			$icjm_job_salary = esc_html( get_post_meta( $post->ID, '_icjm_job_salary', true ) );
			
		
			if (!$icjm_job_type){
				$icjm_job_type  = "-1";
			}
			if (!$icjm_job_category){
				$icjm_job_category  = "-1";
			}
			if (!$icjm_job_status){
				$icjm_job_status  = "-1";
			}
			
			if (!$icjm_job_location){
				$icjm_job_location  = "-1";
			}
			if (!$icjm_job_position){
				$icjm_job_position  = "-1";
			}
			if (!$icjm_job_company){
				$icjm_job_company  = "-1";
			}
			
			?>
           
			<table style="border:1px solid FFFF; width:100%" id="_job_details_meta_box">
            	<tr>
                	<td colspan="2" style="color:#FF0000;"><div class="_icjm_message_row" ></div></td>
                </tr>
				<tr>
					<td> <label for="job_status" class="icjm_normal_label"><?php _e( 'Status', 'icjm_job' )?></label></td>
					<td class="_dropdown_td">
                    	<?php  $this->get_post_type_dropdown("icjm_job_status",$icjm_job_status); ?>
                    </td>
				</tr>
                <tr>
					<td > <label for="job_status" class="icjm_normal_label"><?php _e( 'Category', 'icjm_job' )?></label></td>
					<td  class="_dropdown_td">
                    	<?php  $this->get_post_type_dropdown("icjm_job_category", $icjm_job_category); ?>
                    </td>
				</tr>
                <tr>
					<td > <label for="job_status" class="icjm_normal_label"><?php _e( 'Location', 'icjm_job' )?></label></td>
					<td class="_dropdown_td">
                    	<?php  $this->get_post_type_dropdown("icjm_job_location", $icjm_job_location); ?>
                    </td>
				</tr>
                 <tr>
					<td> <label for="job_status" class="icjm_normal_label"><?php _e( 'Type', 'icjm_job' )?></label></td>
					<td class="_dropdown_td">
                    	<?php  $this->get_post_type_dropdown("icjm_job_type", $icjm_job_type); ?>
                    </td>
				</tr>
                <tr>
					<td > <label for="job_status" class="icjm_normal_label"><?php _e( 'Position', 'icjm_job' )?></label></td>
					<td class="_dropdown_td">
                    	<?php  $this->get_post_type_dropdown("icjm_job_position", $icjm_job_position); ?>
                    </td>
				</tr>
                 <tr>
					<td> <label for="icjm_job_company" class="icjm_normal_label"><?php _e( 'Company', 'icjm_job' )?></label></td>
					<td class="_dropdown_td">
                    	<?php  $this->get_post_type_dropdown("icjm_job_company", $icjm_job_company); ?>
                    </td>
				</tr>
                <tr>
					<td> <label for="job_status" class="icjm_normal_label"><?php _e( 'Expired Date', 'icjm_job' )?></label></td>
					<td>
                    	<input type="text" id="_icjm_job_expired_date" value="<?php echo $icjm_job_expired_date; ?>"  name="_icjm_job_expired_date"  class="_date" />
                    </td>
				</tr>
                <tr>
					<td> <label for="_icjm_job_salary" class="icjm_normal_label"><?php _e( 'Salary', 'icjm_job' )?></label></td>
					<td>
                    	<input type="text" id="_icjm_job_salary" value="<?php echo $icjm_job_salary; ?>"  name="_icjm_job_salary"  />
                    </td>
				</tr>
			</table>
            
             <script type="text/javascript">
            	jQuery(document).ready(function($) {
                    var icjm_job_status = $("#_icjm_job_status option:selected").text();
					//alert(icjm_job_status)
					//$("#_icjm_label_job_status").val(icjm_job_status);
                });
            </script>
            <?php 
			$icjm_type = "hidden"; 
			// $icjm_type = "text"; 
			?>
            <input type="<?php echo $icjm_type; ?>" name="_icjm_job_status_label" 		id="_icjm_job_status_label" value="" />
            <input type="<?php echo $icjm_type; ?>" name="_icjm_job_category_label" 	id="_icjm_job_category_label" value="" />
            <input type="<?php echo $icjm_type; ?>" name="_icjm_job_location_label" 	id="_icjm_job_location_label" value="" />
            <input type="<?php echo $icjm_type; ?>" name="_icjm_job_type_label" 		id="_icjm_job_type_label" value="" />
            <input type="<?php echo $icjm_type; ?>" name="_icjm_job_position_label" 	id="_icjm_job_position_label" value="" />
            <input type="<?php echo $icjm_type; ?>" name="_icjm_job_company_label" 	id="_icjm_job_company_label" value="" />
            <style>
            	.icjm_error_border { border:1px solid red;}
				.icjm_normal_dropdown { width:400px;}
            </style>
			<?php
		}
		
		function icjm_display_company_meta_box($post, $meta_box){
			
			$icjm_company_website = esc_html( get_post_meta( $post->ID, '_icjm_company_website', true ) );
			$icjm_company_email = esc_html( get_post_meta( $post->ID, '_icjm_company_email', true ) );
			$icjm_company_contact_number = esc_html( get_post_meta( $post->ID, '_icjm_company_contact_number', true ) );
			$icjm_company_twitter = esc_html( get_post_meta( $post->ID, '_icjm_company_twitter', true ) );
			$icjm_company_contact_person = esc_html( get_post_meta( $post->ID, '_icjm_company_contact_person', true ) );
			$icjm_company_address = esc_html( get_post_meta( $post->ID, '_icjm_company_address', true ) );
			$icjm_company_tagline = esc_html( get_post_meta( $post->ID, '_icjm_company_tagline', true ) );
			
			
			
		?>
        <table style="border:1px solid #FFFFFF; width:50%">
        	<tr>
            	<td style="width: 100%"> <label for="_icjm_company_website" class="job_status"><?php _e( 'Website', 'icjm_job' )?></label></td>
            	<td>
                <input type="text" id="_icjm_company_website" value="<?php echo $icjm_company_website; ?>"  name="_icjm_company_website"  placeholder="http://www.infosofttech.com" />
            	</td>
			</tr>
            <tr>
            	<td style="width: 100%"> <label for="_icjm_company_email" class="job_status"><?php _e( 'Email', 'icjm_job' )?></label></td>
            	<td>
                <input type="text" id="_icjm_company_email" value="<?php echo $icjm_company_email; ?>"  name="_icjm_company_email"  placeholder="info@infosofttech.com" />
            	</td>
			</tr>
            <tr>
            	<td style="width: 100%"> <label for="_icjm_company_contact_number" class="job_status"><?php _e( 'Contact Number', 'icjm_job' )?></label></td>
            	<td>
                <input type="text" id="_icjm_company_contact_number" value="<?php echo $icjm_company_contact_number; ?>"  name="_icjm_company_contact_number"  placeholder="0222-12358263" />
            	</td>
			</tr>
            <tr>
            	<td style="width: 100%"> <label for="_icjm_company_twitter" class="job_status"><?php _e( 'Twitter', 'icjm_job' )?></label></td>
            	<td>
                <input type="text" id="_icjm_company_twitter" value="<?php echo $icjm_company_twitter; ?>"  name="_icjm_company_twitter"  placeholder="twitter@infosofttech.com" />
            	</td>
			</tr>
            <tr>
            	<td style="width: 100%"> <label for="_icjm_company_contact_person" class="job_status"><?php _e( 'Contact Person', 'icjm_job' )?></label></td>
            	<td>
                <input type="text" id="_icjm_company_contact_person" value="<?php echo $icjm_company_contact_person; ?>"  name="_icjm_company_contact_person"  placeholder="Anzar Ahemd" />
            	</td>
			</tr>
            <tr>
            	<td style="width: 100%"> <label for="_icjm_company_address" class="job_status"><?php _e( 'Full Address', 'icjm_job' )?></label></td>
            	<td>
                <input type="text" id="_icjm_company_address" value="<?php echo $icjm_company_address; ?>"  name="_icjm_company_address"  placeholder="81, Jawahar Nagar, Road No.4, Goregaon (West), Mumbai - 400 062." />
            	</td>
			</tr>
             <tr>
            	<td style="width: 100%"> <label for="_icjm_company_tagline" class="job_status"><?php _e( 'Tagline', 'icjm_job' )?></label></td>
            	<td>
                <input type="text" id="_icjm_company_tagline" value="<?php echo $icjm_company_tagline; ?>"  name="_icjm_company_tagline"  placeholder="will make it possible" />
            	</td>
			</tr>
        </table>
        <?php	
		}
		
		function icjm_display_status_meta_box($post, $meta_box){
			/*#ffffff*/	
			
			$icjm_status_color = esc_html( get_post_meta( $post->ID, '_icjm_status_color', true ) );
			//print_r($post);
			//die;
			?>
			 <table style="border:1px solid #FFFFFF; width:100%">
				 <tr>
					<td> <label for="_icjm_status_color" class="job_status"><?php _e( 'Select Status Color', 'icjm_job' )?></label></td>
					<td>
					<input type="text" id="_icjm_status_color"  name="_icjm_status_color"   class="_icjm_color-field" value="<?php echo $icjm_status_color ?>" data-default-color="#ffffff" />
					</td>
				</tr>
			 </table>
			<?php	
		}
		
		function save_post($ID, $post){
			//$this->print_array($_POST);
			//die;
			if ($post->post_type =="icjm_job") {
				
				/*Save ID*/
				if ( isset( $_POST['_icjm_job_status'] ) && $_POST['_icjm_job_status'] != '' ) {
					update_post_meta( $ID, '_icjm_job_status_id', $_POST['_icjm_job_status'] );
				}
				if ( isset( $_POST['_icjm_job_category'] ) && $_POST['_icjm_job_category'] != '' ) {
					update_post_meta( $ID, '_icjm_job_category_id', $_POST['_icjm_job_category'] );
				}
				if ( isset( $_POST['_icjm_job_location'] ) && $_POST['_icjm_job_location'] != '' ) {
					update_post_meta( $ID, '_icjm_job_location_id', $_POST['_icjm_job_location'] );
				}
				if ( isset( $_POST['_icjm_job_position'] ) && $_POST['_icjm_job_position'] != '' ) {
					update_post_meta( $ID, '_icjm_job_position_id', $_POST['_icjm_job_position'] );
				}
				if ( isset( $_POST['_icjm_job_type'] ) && $_POST['_icjm_job_type'] != '' ) {
					update_post_meta( $ID, '_icjm_job_type_id', $_POST['_icjm_job_type'] );
				}
				if ( isset( $_POST['_icjm_job_expired_date'] ) && $_POST['_icjm_job_expired_date'] != '' ) {
					update_post_meta( $ID, '_icjm_job_expired_date', $_POST['_icjm_job_expired_date'] );
				}
				if ( isset( $_POST['_icjm_job_salary'] ) && $_POST['_icjm_job_salary'] != '' ) {
					update_post_meta( $ID, '_icjm_job_salary', $_POST['_icjm_job_salary'] );
				}
				if ( isset( $_POST['_icjm_job_company'] ) && $_POST['_icjm_job_company'] != '' ) {
					update_post_meta( $ID, '_icjm_job_company_id', $_POST['_icjm_job_company'] );
				}
				/*Save Lable*/
				if ( isset( $_POST['_icjm_job_status_label'] ) && $_POST['_icjm_job_status_label'] != '' ) {
					update_post_meta( $ID, '_icjm_job_status_label', $_POST['_icjm_job_status_label'] );
				}
				if ( isset( $_POST['_icjm_job_category_label'] ) && $_POST['_icjm_job_category_label'] != '' ) {
					update_post_meta( $ID, '_icjm_job_category_label', $_POST['_icjm_job_category_label'] );
				}
				if ( isset( $_POST['_icjm_job_location_label'] ) && $_POST['_icjm_job_location_label'] != '' ) {
					update_post_meta( $ID, '_icjm_job_location_label', $_POST['_icjm_job_location_label'] );
				}
				if ( isset( $_POST['_icjm_job_type_label'] ) && $_POST['_icjm_job_type_label'] != '' ) {
					update_post_meta( $ID, '_icjm_job_type_label', $_POST['_icjm_job_type_label'] );
				}
				if ( isset( $_POST['_icjm_job_position_label'] ) && $_POST['_icjm_job_position_label'] != '' ) {
					update_post_meta( $ID, '_icjm_job_position_label', $_POST['_icjm_job_position_label'] );
				}
				if ( isset( $_POST['_icjm_job_expired_date'] ) && $_POST['_icjm_job_expired_date'] != '' ) {
					update_post_meta( $ID, '_icjm_job_expired_date', $_POST['_icjm_job_expired_date'] );
				}
				if ( isset( $_POST['_icjm_job_salary'] ) && $_POST['_icjm_job_salary'] != '' ) {
					update_post_meta( $ID, '_icjm_job_salary', $_POST['_icjm_job_salary'] );
				}
				if ( isset( $_POST['_icjm_job_company_label'] ) && $_POST['_icjm_job_company_label'] != '' ) {
					update_post_meta( $ID, '_icjm_job_company_label', $_POST['_icjm_job_company_label'] );
				}
				
				
			}
			if ($post->post_type =="icjm_job_company") {
				if ( isset( $_POST['_icjm_company_website'] ) && $_POST['_icjm_company_website'] != '' ) {
					update_post_meta( $ID, '_icjm_company_website', $_POST['_icjm_company_website'] );
				}
				if ( isset( $_POST['_icjm_company_email'] ) && $_POST['_icjm_company_email'] != '' ) {
					update_post_meta( $ID, '_icjm_company_email', $_POST['_icjm_company_email'] );
				}
				if ( isset( $_POST['_icjm_company_contact_number'] ) && $_POST['_icjm_company_contact_number'] != '' ) {
					update_post_meta( $ID, '_icjm_company_contact_number', $_POST['_icjm_company_contact_number'] );
				}
				if ( isset( $_POST['_icjm_company_twitter'] ) && $_POST['_icjm_company_twitter'] != '' ) {
					update_post_meta( $ID, '_icjm_company_twitter', $_POST['_icjm_company_twitter'] );
				}
				if ( isset( $_POST['_icjm_company_contact_person'] ) && $_POST['_icjm_company_contact_person'] != '' ) {
					update_post_meta( $ID, '_icjm_company_contact_person', $_POST['_icjm_company_contact_person'] );
				}
				if ( isset( $_POST['_icjm_company_contact_person'] ) && $_POST['_icjm_company_contact_person'] != '' ) {
					update_post_meta( $ID, '_icjm_company_contact_person', $_POST['_icjm_company_contact_person'] );
				}
				if ( isset( $_POST['_icjm_company_address'] ) && $_POST['_icjm_company_address'] != '' ) {
					update_post_meta( $ID, '_icjm_company_address', $_POST['_icjm_company_address'] );
				}
				if ( isset( $_POST['_icjm_company_tagline'] ) && $_POST['_icjm_company_tagline'] != '' ) {
					update_post_meta( $ID, '_icjm_company_tagline', $_POST['_icjm_company_tagline'] );
				}
			}
			if ($post->post_type =="icjm_job_status") {
			
				if ( isset( $_POST['_icjm_status_color'] ) && $_POST['_icjm_status_color'] != '#ffffff' ) {
						//print_r($_POST);
					//die;	
					update_post_meta( $ID, '_icjm_status_color', $_POST['_icjm_status_color'] );
				}
			}
		}
		
		/*Not Use Move to function page*/
		function get_icjm_jobs_query2($type = "limit"){
			global $wpdb;
			//echo json_encode($_REQUEST);
			
			$icjm_job_status 		= $this->get_request("_icjm_job_status","-1",false);
			$icjm_job_category 	= $this->get_request("_icjm_job_category","-1",false);
			$icjm_job_location 	= $this->get_request("_icjm_job_location","-1",false);
			$icjm_job_type 		= $this->get_request("_icjm_job_type","-1",false);
			$icjm_job_position 	= $this->get_request("_icjm_job_position","-1",false);
			$currentPage		= $this->get_request("p");
			$perPage			= $this->get_request("perPage");
			
			$query = "";
			$query = " SELECT "; 
			$query .= " posts.ID as ID ";
			$query .= ", date_format( posts.post_date, '%Y-%m-%d') as post_date ";
			$query .= ", posts.post_title as post_title ";
			$query .= ", posts.post_content as post_content ";
			
			if($type == 'count'){
				$query =" SELECT count(*) as count";
			}	
			$query .=" FROM  {$wpdb->prefix}posts as posts "; 
			
			/*Status */
			if ($icjm_job_status!="-1") : 
				$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as job_status_id ON job_status_id.post_id= posts.ID";
			endif;
			
			/*Category*/
			if ($icjm_job_category!="-1"):
				$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as job_category_id ON job_category_id.post_id= posts.ID";
			endif;
			
			/*Location*/
			if ($icjm_job_location!="-1"):
				$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as job_location_id ON job_location_id.post_id= posts.ID";
			endif;
			
			/*Location*/
			//if ($icjm_job_location!="-1"):
			//	$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as job_location_id ON job_location_id.post_id= posts.ID";
			//endif;
			
			/*Type*/
			if ($icjm_job_type!="-1"):
				$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as job_type_id ON job_type_id.post_id= posts.ID";
			endif;
			
			/*Position*/
			if ($icjm_job_position!="-1"):
				$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as job_position_id ON job_position_id.post_id= posts.ID";
			endif;
			
			
			
			
			$query .= " WHERE 1=1 ";   
			$query .= " AND posts.post_type = 'icjm_job'";
			$query .= " AND posts.post_status='publish'";
			
			
			/*Job Status*/
			if ($icjm_job_status!="-1") :
				$query .= " AND job_status_id.meta_key='_icjm_job_status_id'";
				$query .= " AND job_status_id.meta_value='{$icjm_job_status}'";
			endif;
			
			
			/*Category*/
			if ($icjm_job_category!="-1"):
				$query .= " AND job_category_id.meta_key='_icjm_job_category_id'";
				$query .= " AND job_category_id.meta_value='{$icjm_job_category}'";
			endif;
			
			/*Location*/
			if ($icjm_job_location!="-1"):
				$query .= " AND job_location_id.meta_key='_icjm_job_location_id'";
				$query .= " AND job_location_id.meta_value='{$icjm_job_location}'";
			endif;
			
			/*Type*/
			if ($icjm_job_type!="-1"):
				$query .= " AND job_type_id.meta_key='_icjm_job_type_id'";
				$query .= " AND job_type_id.meta_value='{$icjm_job_type}'";
			endif;
			
			/*Position*/
			if ($icjm_job_position!="-1"):
				$query .= " AND job_position_id.meta_key='_icjm_job_position_id'";
				$query .= " AND job_position_id.meta_value='{$icjm_job_position}'";
			endif;
			
			
			
			if($type == 'limit'){
		    	$query .= " LIMIT $perPage";
				$query .= ' OFFSET ' . ( $currentPage - 1 ) * $perPage;
				$data = $wpdb->get_results( $query);	
			}
			if($type == 'count'){
				$data = $wpdb->get_var( $query);	
			}
		
			
			//echo $query ;
			
			//$query .= " AND job_status.meta_key='_icjm_job_category_label'";
			
			
		//	$data = $wpdb->get_results( $query);	
			//$this->print_array($results);
			return $data;	
		}
		
		function get_icjm_jobs(){
			$jobs = $this->get_icjm_post_meta();
			if (count($jobs)=="0"){
				//echo "No record found.";	
				return false;
			}
			//$this->print_array($jobs);
			?>
            
            <div class="table-responsive">
				<div class="icjm_job-listing">
					<table class="icjm_table icjm_table-striped">
						<thead>
							<tr>
								<th>Job List</th>
								<th>Position</th>
								<th>Location</th>
								<th>Type</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($jobs as $key=>$value) : ?> 
						<tr>
							<td class="icjm_job_title">
								<h3><?php echo $value->post_title; ?></h3>
								<span class="icjm_company"><?php echo $value->icjm_job_company_label; ?></span>
							</td>
							<td class="icjm_job_position"><?php echo $value->icjm_job_position_label; ?></td>
							<td class="icjm_job_location"><!--<i class="fa fa-map-marker"></i>--><?php echo $value->icjm_job_location_label; ?></td>
							<td class="icjm_job_type">
								<span><?php echo $value->icjm_job_type_label; ?></span><br>
								<span class="icjm_time"><?php echo $value->post_date; ?></span>
							</td>
							<td><a href="<?php echo get_permalink($value->ID)."&action=apply"; ?>">View</a> </td>
						</tr>   
						<?php endforeach; ?> 
						</tbody>   
					</table>
				</div>
            </div>
              <form id="job_pagination_form" class="<?php echo $admin_page ;?>_form" action="<?php echo $targetpage;?>" method="post">
				<?php foreach($_REQUEST as $key => $value):?>
					<input type="hidden" name="<?php echo $key;?>" value="<?php echo $value;?>" />
				<?php endforeach;?>
			</form>
            <?php
			//echo json_encode($_REQUEST);
			$count = $this->get_icjm_jobs_query("count");
			echo $this->get_pagination($count,$_REQUEST["perPage"]);
			//return $jobs;
		}
		
		/*Normal CSS*/
		function get_icjm_jobs2(){
			$jobs = $this->get_icjm_post_meta();
			if (count($jobs)=="0"){
				//echo "No record found.";	
				return false;
			}
			//$this->print_array($jobs);
			?>
            <div class="job-listing-table">
            <table class="table table-hover table-striped">
            	<tr>
                	<td>Job Title</td>
                    <td>Post Date</td>
                    <td>Status</td>
                    <td>Category</td>
                    <td>Location</td>
                    <td>Type</td>
                    <td>Position</td>
                    <td>Company</td>
                    <td>Expired Date</td>
                    <td>Salary</td>
                    <td>View</td>
                </tr>
                <tbody>
            <?php foreach($jobs as $key=>$value) : ?>
                <tr>
                	<td><?php echo $value->post_title; ?></td>
                    <td><?php echo $value->post_date; ?></td>
                    <td><?php echo $value->icjm_job_status_label; ?></td>
                    <td><?php echo $value->icjm_job_category_label; ?></td>
                    <td><?php echo $value->icjm_job_location_label; ?></td>
                    <td><?php echo $value->icjm_job_type_label; ?></td>
                    <td><?php echo $value->icjm_job_position_label; ?></td>
                    <td><?php echo $value->icjm_job_company_label; ?></td>
                    <td><?php echo $value->icjm_job_expired_date; ?></td>
                    <td><?php echo $value->icjm_job_salary; ?></td>
                    <td><a href="<?php echo get_permalink($value->ID) ?>">View</a></td>
                </tr>
            <?php endforeach; ?> 
            	</tbody>   
            </table>
            </div>
              <form id="job_pagination_form" class="<?php echo $admin_page ;?>_form" action="<?php echo $targetpage;?>" method="post">
				<?php foreach($_REQUEST as $key => $value):?>
					<input type="hidden" name="<?php echo $key;?>" value="<?php echo $value;?>" />
				<?php endforeach;?>
			</form>
            <?php
			//echo json_encode($_REQUEST);
			$count = $this->get_icjm_jobs_query("count");
			echo $this->get_pagination($count,$_REQUEST["perPage"]);

			//return $jobs;
		}
		
		function ajax(){
			$jobs = $this->get_icjm_jobs();
			//echo json_encode($jobs );
			//echo "dsad";
			die;
		}	
	}
}
?>