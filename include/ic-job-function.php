<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! class_exists( 'icjm_job_function' ) ) { 
	class icjm_job_function{
		public function __construct(){
		}
		
		function get_post_type_dropdown($post_type, $selected){
			global $wpdb;
			$query = "SELECT ";
			$query .= " post.ID as ID";
			$query .= " ,post.post_title as Value";
			$query .= " FROM {$wpdb->prefix}posts as post  ";
			$query .= " WHERE 1=1  ";
			$query .= " AND  post.post_type = '{$post_type}'";
			$query .= " AND  post.post_status = 'publish'";
			//$query .= " Order By Value ";
			
			$results = $wpdb->get_results( $query);	
			?>
            <select name="<?php echo "_".$post_type ?>" id="<?php echo "_".$post_type ?>" class="<?php echo "_".$post_type ?> _dropdown icjm_normal_dropdown" >            	
				<?php if ($selected == "-1") : ?>
            		<option selected="selected" value="-1">-Select-</option>
                <?php else: ?>
                	<option value="-1">-Select-</option>
                <?php endif; ?>
                
            	<?php foreach ($results as $k => $v) : ?>
                <?php if ( $selected == $v->ID) : ?>
                	<option selected="selected" value="<?php echo $v->ID ?>"><?php echo $v->Value ?></option>
                <?php else : ?>
                 	<option value="<?php echo $v->ID ?>"><?php echo $v->Value ?></option>
          		<?php endif;  ?>
				<?php endforeach; ?>
            </select>
            <?php
		}
		
		public function get_request($name,$default = NULL,$set = false){
			if(isset($_REQUEST[$name])){
				$newRequest = $_REQUEST[$name];
				
				if(is_array($newRequest)){
					$newRequest = implode(",", $newRequest);
				}else{
					$newRequest = trim($newRequest);
				}
				
				if($set) $_REQUEST[$name] = $newRequest;
				
				return $newRequest;
			}else{
				if($set) 	$_REQUEST[$name] = $default;
				return $default;
			}
		}
		
		function get_all_request(){
			global $request;
			if(!$this->request){
				$request 			= array();
			
				if(isset($_REQUEST)){
					foreach($_REQUEST as $key => $value ):					
						$v =  $this->get_request($key,NULL);
						$request[$key]		= $v;
					endforeach;
				}
				$this->request = $request;				
			}else{				
				$request = $this->request;
			}
			
			return $request;
		}
		
		function get_icjm_jobs_query($type = "limit"){
			global $wpdb;
			//echo json_encode($_REQUEST);
			
			$start_date 		=  $this->get_request("start_date");
			$end_date 			=  $this->get_request("end_date");
			
			$icjm_job_status 		= $this->get_request("_icjm_job_status","-1",false);
			$icjm_job_category 	= $this->get_request("_icjm_job_category","-1",false);
			$icjm_job_location 	= $this->get_request("_icjm_job_location","-1",false);
			$icjm_job_type 		= $this->get_request("_icjm_job_type","-1",false);
			$icjm_job_position 	= $this->get_request("_icjm_job_position","-1",false);
			$currentPage		= $this->get_request("p",1,false);
			$perPage			= $this->get_request("perPage",3,false);
			
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
			
			if ($start_date && $end_date) :
				$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$start_date}' AND '{$end_date}' ";
			endif;
			
			
			
			if($type == 'limit'){
				$query .= " Order By posts.post_date DESC";
		    	$query .= " LIMIT $perPage";
				$query .= ' OFFSET ' . ( $currentPage - 1 ) * $perPage;
				
				$data = $wpdb->get_results( $query);	
			}
			if($type == 'count'){
				$query .= " Order By posts.post_date DESC";
				$data = $wpdb->get_var( $query);	
			}
			if($type == 'export'){
				$query .= " Order By posts.post_date DESC";
				$data = $wpdb->get_results( $query);	
			}
			
			//echo $query ;
			
			//$query .= " AND job_status.meta_key='_icjm_job_category_label'";
			
			
		//	$data = $wpdb->get_results( $query);	
			//$this->print_array($results);
			return $data;	
		}
		
		function get_icjm_post_meta($type = "limit")
		{	
			$job_data =$this->get_icjm_jobs_query($type);
			//echo $count = $this->get_icjm_jobs_query("count");
			//echo $this->get_pagination($count,3);
			if(count($job_data)> 0){
				foreach($job_data as $k => $v){
					
					/*Order Data*/
				    $job_id =$v->ID;
					$job_detail = $this->get_job_detail($job_id);
					foreach($job_detail as $dkey => $dvalue)
					{
							$job_data[$k]->$dkey =$dvalue;
						
					}
				}
			}
			else
			{
				echo "No Record Found";
			}
			return $job_data;
		}
		
		function get_job_detail($order_id)
		{
		
			$order_detail	= get_post_meta($order_id);
			$order_detail_array = array();
			foreach($order_detail as $k => $v)
			{
				$k =substr($k,1);
				$order_detail_array[$k] =$v[0];
			}
			return 	$order_detail_array;
		}
		
		function get_icjm_post_type($post_type, $ID=NULL){
			
			global $wpdb;
			$query = "SELECT * ";
			//$query .= " post.ID as ID";
			//$query .= " ,post.post_title as Value";
			$query .= " FROM {$wpdb->prefix}posts as post  ";
			$query .= " WHERE 1=1  ";
			$query .= " AND  post.post_type = '{$post_type}'";
			$query .= " AND  post.post_status = 'publish'";
			if ($ID)
			$query .= " AND  post.ID = '{$ID}'";
			$results = $wpdb->get_results( $query);	
			return 	$results ;	
			
		}
		
		function icjm_get_post_meta($ID, $meta_key=array(), $type = "RESULT"){
			
			$count = count ($meta_key);
			$meta_key = implode("', '", $meta_key);
			
		
			global $wpdb;
			$query = "SELECT * ";
			if ($type == "VAR") 
			$query = "SELECT  postmeta.meta_value  ";	
			$query .= " FROM {$wpdb->prefix}postmeta as postmeta  ";
			$query .= " WHERE 1=1  ";
			if ($ID)
			$query .= " AND  postmeta.post_id = '{$ID}'";
			if ($count>0){
				$query .= " AND  postmeta.meta_key IN ('{$meta_key}')";
			}
			if ($type == "VAR")
				$results = $wpdb->get_var( $query);	
			else
				$results = $wpdb->get_results( $query);	
			//echo $query;
			return 	$results ;		
		}
		
		function print_array($ar = NULL,$display = true){
			if($ar){
				$output = "<pre>";
				$output .= print_r($ar,true);
				$output .= "</pre>";
				
				if($display){
					echo $output;
				}else{
					return $output;
				}
			}
		}
		
		function get_pagination($total_pages = 50,$limit = 10,$adjacents = 3,$targetpage = "admin.php?page=RegisterDetail",$request = array()){		
				
				if(count($request)>0){
					unset($request['p']);					
				}
				
				/* Setup vars for query. */
				//$targetpage = "admin.php?page=RegisterDetail"; 	//your file name  (the name of this file)										
				
				/* Setup page vars for display. */
				if(isset($_REQUEST['p'])){
					$page = $_REQUEST['p'];
					$_GET['p'] = $page;
					$start = ($page - 1) * $limit; 			//first item to display on this page
				}else{
					$page = false;
					$start = 0;	
					$page = 1;
				}
				
				if ($page == 0) $page = 1;					//if no page var is given, default to 1.
				$prev = $page - 1;							//previous page is page - 1
				$next = $page + 1;							//next page is page + 1
				$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
				$lpm1 = $lastpage - 1;						//last page minus 1
				
				
				
				$label_previous = __('previous', 'icwoocommerce_textdomains');
				$label_next = __('next', 'icwoocommerce_textdomains');
				
				/* 
					Now we apply our rules and draw the pagination object. 
					We're actually saving the code to a variable in case we want to draw it more than once.
				*/
				$pagination = "";
				if($lastpage > 1)
				{	
					$pagination .= "<div class=\"pagination\">";
					//previous button
					if ($page > 1) 
						$pagination.= "<a href=\"$targetpage&p=$prev\" data-p=\"$prev\">{$label_previous}</a>\n";
					else
						$pagination.= "<span class=\"disabled\">{$label_previous}</span>\n";	
					
					//pages	
					if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
					{	
						for ($counter = 1; $counter <= $lastpage; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>\n";
							else
								$pagination.= "<a href=\"$targetpage&p=$counter\" data-p=\"$counter\">$counter</a>\n";					
						}
					}
					elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
					{
						//close to beginning; only hide later pages
						if($page < 1 + ($adjacents * 2))		
						{
							for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
							{
								if ($counter == $page)
									$pagination.= "<span class=\"current\">$counter</span>\n";
								else
									$pagination.= "<a href=\"$targetpage&p=$counter\" data-p=\"$counter\">$counter</a>\n";					
							}
							$pagination.= "...";
							$pagination.= "<a href=\"$targetpage&p=$lpm1\" data-p=\"$lpm1\">$lpm1</a>\n";
							$pagination.= "<a href=\"$targetpage&p=$lastpage\" data-p=\"$lastpage\">$lastpage</a>\n";		
						}
						//in middle; hide some front and some back
						elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
						{
							$pagination.= "<a href=\"$targetpage&p=1\" data-p=\"1\">1</a>\n";
							$pagination.= "<a href=\"$targetpage&p=2\" data-p=\"2\">2</a>\n";
							$pagination.= "...";
							for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
							{
								if ($counter == $page)
									$pagination.= "<span class=\"current\">$counter</span>\n";
								else
									$pagination.= "<a href=\"$targetpage&p=$counter\" data-p=\"$counter\">$counter</a>\n";					
							}
							$pagination.= "...";
							$pagination.= "<a href=\"$targetpage&p=$lpm1\" data-p=\"$lpm1\">$lpm1</a>\n";
							$pagination.= "<a href=\"$targetpage&p=$lastpage\" data-p=\"$lastpage\">$lastpage</a>\n";		
						}
						//close to end; only hide early pages
						else
						{
							$pagination.= "<a href=\"$targetpage&p=1\" data-p=\"1\">1</a>\n";
							$pagination.= "<a href=\"$targetpage&p=2\" data-p=\"2\">2</a>\n";
							$pagination.= "...";
							for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
							{
								if ($counter == $page)
									$pagination.= "<span class=\"current\">$counter</span>\n";
								else
									$pagination.= "<a href=\"$targetpage&p=$counter\" data-p=\"$counter\">$counter</a>\n";					
							}
						}
					}
					
					//next button
					if ($page < $counter - 1) 
						$pagination.= "<a href=\"$targetpage&p=$next\" data-p=\"$next\">{$label_next}</a>\n";
					else
						$pagination.= "<span class=\"disabled\">{$label_next}</span>\n";
					$pagination.= "</div>\n";		
				}
				return $pagination;
			
		}//End Get Pagination
		
		/*Export*/
		function ExportToCsv($filename = 'export.csv',$rows,$columns,$format="csv"){				
			global $wpdb;
			$csv_terminated = "\n";
			$csv_separator = ",";
			$csv_enclosed = '"';
			$csv_escaped = "\\";
			$fields_cnt = count($columns); 
			$schema_insert = '';
			
			if($format=="xls"){
				$csv_terminated = "\r\n";
				$csv_separator = "\t";
			}
				
			foreach($columns as $key => $value):
				$l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $value) . $csv_enclosed;
				$schema_insert .= $l;
				$schema_insert .= $csv_separator;
			endforeach;// end for
		 
		   $out = trim(substr($schema_insert, 0, -1));
		   $out .= $csv_terminated;
			
			//printArray($rows);
			
			for($i =0;$i<count($rows);$i++){
				
				//printArray($rows[$i]);
				$j = 0;
				$schema_insert = '';
				foreach($columns as $key => $value){
						
						
						 if ($rows[$i][$key] == '0' || $rows[$i][$key] != ''){
							if ($csv_enclosed == '')
							{
								$schema_insert .= $rows[$i][$key];
							} else
							{
								$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $rows[$i][$key]) . $csv_enclosed;
							}
						 }else{
							$schema_insert .= '';
						 }
						
						
						
						if ($j < $fields_cnt - 1)
						{
							$schema_insert .= $csv_separator;
						}
						$j++;
				}
				$out .= $schema_insert;
				$out .= $csv_terminated;
			}
			
			if($format=="csv"){
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Content-Length: " . strlen($out));	
				header("Content-type: text/x-csv");
				header("Content-type: text/csv");
				header("Content-type: application/csv");
				header("Content-Disposition: attachment; filename=$filename");
			}elseif($format=="xls"){
				
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Content-Length: " . strlen($out));
				header("Content-type: application/octet-stream");
				header("Content-Disposition: attachment; filename=$filename");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			
			echo $out;
			exit;
		 
		}
		/*End Export To CSV*/
	}
}
?>