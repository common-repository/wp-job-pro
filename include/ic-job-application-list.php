<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
if( ! class_exists( 'icjm_job_application_list' ) ) {
	class icjm_job_application_list extends WP_List_Table{
	
		function __construct() {
			parent::__construct( array(
				'singular'	=> 'icjm_job_application_list', //Singular label
				'plural' 	=> 'icjm_job_application_lists', //plural label, also this well be one of the table css class
				'ajax'   	=> false //We won't support Ajax for this table
				) 
			);
		}
		
		function column_default($item, $column_name){
			switch($column_name){
				case 'title':
				case 'post_date':
				case 'first_name':
				case 'last_name':
				case 'email_address':
				case 'contact_no':
				case 'about_yourself':
				case 'icjm_job_company_label':
					return $item->$column_name;
				break;
				//case 'first_name':
					//return $item->$column_name;
				default:
					//return print_r($item,true); //Show the whole array for troubleshooting purposes
			}
		}
		
		function get_columns(){
			$columns = array(
				'cb'        			=> '<input type="checkbox" />', //Render a checkbox instead of text
				'title'     	 		=> 'Job Title',
				'post_date'     		=> 'Date',
				'first_name'    		=> 'First Name',
				'last_name'     		=> 'Last Name',
				'contact_no'    		=> 'Contact No',
				'email_address'  		=> 'Email Address',
				'about_yourself'  		=> 'About Yourself',
				'icjm_job_company_label'	=>'Company Name'
			);
			return $columns;
		}
		
		function icjm_prepare_items() {
			global $wpdb; //This is used only if making any database queries
			
			/* -- Preparing your query -- */
			$query = "SELECT  ";
			$query .= " posts.ID as post_id ";
			$query .= " ,posts.post_title as title ";
			$query .= " , date_format( posts.post_date, '%Y-%m-%d')  as post_date ";
			$query .= " ,first_name.meta_value as first_name ";
			$query .= " ,last_name.meta_value as last_name ";
			$query .= " ,email_address.meta_value as email_address ";
			$query .= " ,contact_no.meta_value as contact_no ";
			$query .= " ,about_yourself.meta_value as about_yourself ";
			$query .= " ,icjm_job_company_label.meta_value as icjm_job_company_label ";
			
			$query .= " FROM {$wpdb->prefix}posts as posts ";
			
			/*First Name*/
			$query .=" LEFT JOIN  {$wpdb->prefix}postmeta as first_name ON first_name.post_id=posts.ID ";
			
			/*Last Name*/
			$query .=" LEFT JOIN  {$wpdb->prefix}postmeta as last_name ON last_name.post_id=posts.ID ";
			
			/*Email Address*/
			$query .=" LEFT JOIN  {$wpdb->prefix}postmeta as email_address ON email_address.post_id=posts.ID ";
			
			/*Email Address*/
			$query .=" LEFT JOIN  {$wpdb->prefix}postmeta as contact_no ON contact_no.post_id=posts.ID ";
			
			/*about yourself*/
			$query .=" LEFT JOIN  {$wpdb->prefix}postmeta as about_yourself ON about_yourself.post_id=posts.ID ";
			
			
			/*Company _icjm_job_company_label*/
			$query .=" LEFT JOIN  {$wpdb->prefix}postmeta as icjm_job_company_label ON icjm_job_company_label.post_id=posts.ID ";
			
				
			
			$query .= " WHERE 1=1 ";   
			$query .= " AND posts.post_type = 'icjm_job_application'"; 
			$query .= " AND posts.post_status='publish'";
			
			/*First Name*/
			$query .= " AND first_name.meta_key='_first_name'";
			
			/*Last Name*/
			$query .= " AND last_name.meta_key='_last_name'";
			
			/*Email Address*/
			$query .= " AND email_address.meta_key='_email_address'";
			
			/*Contact*/
			$query .= " AND contact_no.meta_key='_contact_no'";
			
			/*Contact*/
			$query .= " AND about_yourself.meta_key='_about_yourself'";
			
			/*Contact*/
			$query .= " AND icjm_job_company_label.meta_key='_icjm_job_company_label'";
			
			/* -- Ordering parameters -- */
			//Parameters that are going to be used to order the result
			//$orderby = !empty($_GET["orderby"]) ? mysql_real_escape_string($_GET["orderby"]) : 'ASC';
			//$order = !empty($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : '';
			
			
			$orderby = isset($_GET["orderby"])?$_GET["orderby"] :'ASC';
			$order = isset($_GET["order"]) ?$_GET["order"] :'';
			
			
			if (!empty($orderby) & !empty($order)) {
				$query.=' ORDER BY ' . $orderby . ' ' . $order;
			}else{
					$query.=' ORDER BY post_id DESC';
			}
			//
			
			$totalitems = $wpdb->query($query);
			
			/**
			* First, lets decide how many records per page to show
			*/
			$perpage = 5;
			
			//Which page is this?
			//$paged = !empty($_GET["paged"]) ? mysql_real_escape_string($_GET["paged"]) : '';
			$paged =  isset($_GET["paged"]) ?$_GET["paged"] :'';
			//Page Number
			if (empty($paged) || !is_numeric($paged) || $paged <= 0) {
			$paged = 1;
			}
			
			
			//How many pages do we have in total?
			$totalpages = ceil($totalitems / $perpage);
			//adjust the query to take pagination into account
			if (!empty($paged) && !empty($perpage)) {
			$offset = ($paged - 1) * $perpage;
			$query.=' LIMIT ' . (int) $offset . ',' . (int) $perpage;
			}
			
			/* -- Register the pagination -- */
			$this->set_pagination_args(array(
				"total_items" => $totalitems,
				"total_pages" => $totalpages,
				"per_page" => $perpage,
			));
			
			$columns = $this->get_columns();
			$hidden = array();
			$sortable = array();
			
			$this->_column_headers = array($columns, $hidden, $sortable);
			
			$this->items = $wpdb->get_results($query);
			
			/*
			print "<pre>";
			print_r($this->items);
			print "</pre>";
			echo $query;
			*/
			//echo $query;
			//print_r($this->items);
		}
		
		function display_job_application(){
			
			$this->icjm_prepare_items();
			
			?>
            <div class="wrap">
            	<div id="icon-users" class="icon32"><br/></div>
        		<h2>Job Application List</h2>  
                <form id="frm_job_application" method="get">
                	<!-- For plugins, we also need to ensure that the form posts back to our current page -->
                	<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                	<!-- Now we can render the completed list table -->
                	<?php $this->display(); ?>
                </form>     
            </div>
            <?php
		}
	}
	//$obj = new icjm_job_application_list();
}
?>