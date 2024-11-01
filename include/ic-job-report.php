<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! class_exists( 'icjm_job_report' ) ) { 
	include_once("ic-job-function.php");
	class icjm_job_report  extends icjm_job_function{ 
		var $constants = array();
		public function __construct($constants = array()){
			//echo "dasdas";
		}
		
		function ajax(){
			$call =  isset($_REQUEST["call"])?$_REQUEST["call"] : '';
			
			switch ($call) {
				case "get_report":
					$this->get_report();
					break;
				default:
					break;
			}
			//echo json_encode($_REQUEST);
			die;
		}
		
		function init(){
			
		$report_type =	isset($_REQUEST["report_type"])?$_REQUEST["report_type"] : 'icjm_job_dashbaord';
		
		$_REQUEST["report_type"] = $report_type;
		
		$page =	isset($_REQUEST["page"])?$_REQUEST["page"] : '';
	
		$page_titles =  array();
		$page_titles["icjm_job_dashbaord"] 	= __('Dashbaord',	'icjm_job');	 	
		$page_titles["icjm_job_report"] 		= __('Report',		'icjm_job');			
		
		?>
		<div class="header">
			<h2>Report Section</h2>
			 <h2 class="nav-tab-wrapper woo-nav-tab-wrapper hide_for_print">
			 <div class="responsive-menu"><a href="#" id="menu-icon"></a></div>
				<?php            	
				   foreach ( $page_titles as $key => $value ) {
						echo '<a href="'.admin_url( 'edit.php?post_type=icjm_job&page='.$page.'&report_type=' . urlencode( $key ) ).'" class="nav-tab ';
						if ( $report_type == $key ) echo 'nav-tab-active';
						echo '">' . esc_html( $value ) . '</a>';
				   }
				?>
			</h2>
		</div>
        <?php 
			if ($report_type == "icjm_job_dashbaord"){
				$this->get_dashbaord();
			} 
			if ($report_type == "icjm_job_report"){
					//echo "icjm_job_report";
				$type = "hidden";  
				//$type = "text";
				$start_date 			=  $this->get_request("start_date",date_i18n("Y-m-d"),true);
				$end_date 				=  $this->get_request("end_date",date_i18n("Y-m-d"),true);
				
				?>
				
				<div class="wrap">
					<div class="Search">
						<div class="custom-search" style="margin-bottom:20px;">
							<div class="search-heading">Custom Search</div>
							<div class="content">
									
								<form id="frm_backend_job_search" class="custom_form">
									<div class="form-group">
										<div class="FormRow FirstRow">
											<label class="label-text">Start Date:</label>
											<div class="input-text">
												<input type="text" name="start_date" id="start_date" class="_date" value="<?php echo $start_date; ?>" />
											</div>
										</div>
										
										<div class="FormRow">
											<label class="label-text">End Date:</label>
											<div class="input-text">
												<input type="text" name="end_date" id="end_date" class="_date"  value="<?php echo $end_date; ?>" />
											</div>
										</div>
									</div>
									<div class="clearfix"></div>
									
									<div class="text-center">
										<input type="<?php echo $type ?>" name="action" 		id="action" 	value="icjm_job_ajax_request" />
										<input type="<?php echo $type ?>" name="sub_action" 	id="sub_action" value="icjm_job_backend" />
										<input type="<?php echo $type ?>" name="call" 			id="call" value="get_report" />
										<input type="<?php echo $type ?>"  name="perPage" id="perPage" value="4"/>
										<input type="<?php echo $type ?>"  name="p" id="p" value="1"  />
										<input type="submit" value="Search" class="icjm_job_btn" />
									</div>
								</form>
							
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				
				<div class="ajax_content"></div>
                
				 <script type="text/javascript">
					jQuery(function($){
						$("#frm_backend_job_search").submit(function(e) {
							//alert("dsad");
							$.ajax({
								url:icjm_job_ajax_object.icjm_job_ajax_url,
								data:$("#frm_backend_job_search").serialize(),
								success:function(data) {
									$(".ajax_content").html(data);
								},
								error: function(errorThrown){
									console.log(errorThrown);
									alert("e");
								}
							}); 
							e.preventDefault(); // avoid to execute the actual submit of the form.
						});
						
						$(document).on("click",".pagination a", function(){
							var p = $(this).attr("data-p");
							$("#frm_backend_job_search").find("input[name=p]").val(p);
							$("#frm_backend_job_search").submit();
								return false;
						});
							
						$("#frm_backend_job_search").trigger("submit");	
					});
				</script>
                <?php	
				//$this->get_report();
			}
		}
		function  get_dashbaord(){
			//echo "icjm_job_dashbaord 1";
			//echo $this->get_toatal_status();
		?>
		<div class="wrap">
        <div class="Dashboard icjm_job_dashboard">
			<div style="margin-bottom:20px;">
				<div class="custom-search">
					<div class="search-heading">Dashboard Summary</div>
					<div class="container">
						<div class="content">					
							<div class="block block-orange">
								<div class="block-content">
									<img src="../assets/images/icons/sales-icon.png" alt="">
									<p class="stat">
										<!--<span class="amount">$421,229.57</span>-->
										<span class="count">
											<?php
												$result = $this->get_icjm_post_type("icjm_job_status");
												echo '#' . $count  = count($result );
											?>
										</span>
									</p>
								</div>
								<h2><span>Total Status</span></h2>
							</div>
							
							<div class="block block-purple">
								<div class="block-content">
									<img src="http://plugins.infosofttech.com/woogoldversion/wp-content/plugins/ic-woocommerce-advance-sales-report-golden/assets/images/icons/sales-icon.png" alt="">
									<p class="stat">
										<!--<span class="amount">$421,229.57</span>-->
										<span class="count">
											<?php
												$result = $this->get_icjm_post_type("icjm_job_category");
												echo '#' . $count  = count($result );
											?>
										</span>
									</p>
								</div>
								<h2><span>Total Category</span></h2>
							</div>
							
							<div class="block block-green">
								<div class="block-content">
									<i class="fa fa-map-marker"></i>
									<p class="stat">
										<!--<span class="amount">$421,229.57</span>-->
										<span class="count">
											<?php
												$result = $this->get_icjm_post_type("icjm_job_location");
												echo '#' . $count  = count($result );
											?>
										</span>
									</p>
								</div>
								<h2><span>Total Location</span></h2>
							</div>
							
							<div class="block block-green2">
								<div class="block-content">
									<img src="http://plugins.infosofttech.com/woogoldversion/wp-content/plugins/ic-woocommerce-advance-sales-report-golden/assets/images/icons/sales-icon.png" alt="">
									<p class="stat">
										<!--<span class="amount">$421,229.57</span>-->
										<span class="count">
											<?php
												$result = $this->get_icjm_post_type("icjm_job_type");
												echo '#' . $count  = count($result );
											?>
										</span>
									</p>
								</div>
								<h2><span>Total Type</span></h2>
							</div>
							
							<div class="block block-green3">
								<div class="block-content">
									<img src="http://plugins.infosofttech.com/woogoldversion/wp-content/plugins/ic-woocommerce-advance-sales-report-golden/assets/images/icons/sales-icon.png" alt="">
									<p class="stat">
										<!--<span class="amount">$421,229.57</span>-->
										<span class="count">
											<?php
												$result = $this->get_icjm_post_type("icjm_job_position");
												echo '#' . $count  = count($result );
											?>
										</span>
									</p>
								</div>
								<h2><span>Total Position</span></h2>
							</div>
							
							<div class="block block-light-green">
								<div class="block-content">
									<img src="http://plugins.infosofttech.com/woogoldversion/wp-content/plugins/ic-woocommerce-advance-sales-report-golden/assets/images/icons/sales-icon.png" alt="">
									<p class="stat">
										<!--<span class="amount">$421,229.57</span>-->
										<span class="count">
											<?php
												$result = $this->get_icjm_post_type("icjm_job_company");
												echo '#' . $count  = count($result );
											?>
										</span>
									</p>
								</div>
								<h2><span>Total Company</span></h2>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			
			<div class="row" style="display:none;">
				<div class="col-md-4">
					<div class="jobpostbox">
						<div class="custom-search">
						<div class="search-heading">Total Status</div>
							<div class="grid">	
								 <table style="width:100%" class="widefat">
									<thead>
										<tr class="first">
											<th>Sales Order</th>
											<th class="order_count">Order Count</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Today</td>
											<td class="order_count">0</td>
										</tr>
										<tr class="alternate">
											<td>Yesterday</td>
											<td class="order_count">0</td>
										</tr>
										<tr>
											<td>Week</td>
											<td class="order_count">0</td>
										</tr>
										<tr class="alternate">
											<td>Yesterday</td>
											<td class="order_count">0</td>
										</tr>
										<tr>
											<td>Week</td>
											<td class="order_count">0</td>
										</tr>
									</tbody>
								</table>		
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="jobpostbox">
						<div class="custom-search">
						<div class="search-heading">Total Category</div>
							<div class="grid">	
								 <table style="width:100%" class="widefat">
									<thead>
										<tr class="first">
											<th>Sales Order</th>
											<th class="order_count">Order Count</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Today</td>
											<td class="order_count">0</td>
										</tr>
										<tr class="alternate">
											<td>Yesterday</td>
											<td class="order_count">0</td>
										</tr>
										<tr>
											<td>Week</td>
											<td class="order_count">0</td>
										</tr>
										<tr class="alternate">
											<td>Yesterday</td>
											<td class="order_count">0</td>
										</tr>
										<tr>
											<td>Week</td>
											<td class="order_count">0</td>
										</tr>
									</tbody>
								</table>		
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="jobpostbox">
						<div class="custom-search">
						<div class="search-heading">Total Location</div>
							<div class="grid">	
								 <table style="width:100%" class="widefat">
									<thead>
										<tr class="first">
											<th>Sales Order</th>
											<th class="order_count">Order Count</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Today</td>
											<td class="order_count">0</td>
										</tr>
										<tr class="alternate">
											<td>Yesterday</td>
											<td class="order_count">0</td>
										</tr>
										<tr>
											<td>Week</td>
											<td class="order_count">0</td>
										</tr>
										<tr class="alternate">
											<td>Yesterday</td>
											<td class="order_count">0</td>
										</tr>
										<tr>
											<td>Week</td>
											<td class="order_count">0</td>
										</tr>
									</tbody>
								</table>		
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="jobpostbox">
						<div class="custom-search">
						<div class="search-heading">Total Type</div>
							<div class="grid">	
								 <table style="width:100%" class="widefat">
									<thead>
										<tr class="first">
											<th>Sales Order</th>
											<th class="order_count">Order Count</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Today</td>
											<td class="order_count">0</td>
										</tr>
										<tr class="alternate">
											<td>Yesterday</td>
											<td class="order_count">0</td>
										</tr>
										<tr>
											<td>Week</td>
											<td class="order_count">0</td>
										</tr>
										<tr class="alternate">
											<td>Yesterday</td>
											<td class="order_count">0</td>
										</tr>
										<tr>
											<td>Week</td>
											<td class="order_count">0</td>
										</tr>
									</tbody>
								</table>		
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="jobpostbox">
						<div class="custom-search">
						<div class="search-heading">Total Position</div>
							<div class="grid">	
								 <table style="width:100%" class="widefat">
									<thead>
										<tr class="first">
											<th>Sales Order</th>
											<th class="order_count">Order Count</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Today</td>
											<td class="order_count">0</td>
										</tr>
										<tr class="alternate">
											<td>Yesterday</td>
											<td class="order_count">0</td>
										</tr>
										<tr>
											<td>Week</td>
											<td class="order_count">0</td>
										</tr>
										<tr class="alternate">
											<td>Yesterday</td>
											<td class="order_count">0</td>
										</tr>
										<tr>
											<td>Week</td>
											<td class="order_count">0</td>
										</tr>
									</tbody>
								</table>		
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="jobpostbox">
						<div class="custom-search">
						<div class="search-heading">Total Company</div>
							<div class="grid">	
								 <table style="width:100%" class="widefat">
									<thead>
										<tr class="first">
											<th>Sales Order</th>
											<th class="order_count">Order Count</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Today</td>
											<td class="order_count">0</td>
										</tr>
										<tr class="alternate">
											<td>Yesterday</td>
											<td class="order_count">0</td>
										</tr>
										<tr>
											<td>Week</td>
											<td class="order_count">0</td>
										</tr>
										<tr class="alternate">
											<td>Yesterday</td>
											<td class="order_count">0</td>
										</tr>
										<tr>
											<td>Week</td>
											<td class="order_count">0</td>
										</tr>
									</tbody>
								</table>		
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
        <?php	
		}
		function  get_report(){
			$type = "hidden";  
			//$type = "text";
			$jobs = $this->get_icjm_post_meta();
			if (count($jobs)>0){
				?>
				<div class="wrap">
					<div class="dashboard icjm_job_dashboard">
						<div class="total_report">
							<div class="text-right">
								<form id="job_export_form" class="<?php echo $admin_page ;?>_form" action="<?php echo $targetpage;?>" method="post">
									  <input type="submit" value="Excel" name="btn_excel_export" class="ni_btn icjm_job_btn" id="btn_excel_export" />
									<?php foreach($_REQUEST as $key => $value):?>
										<input type="<?php echo $type ?>" name="<?php echo $key;?>" value="<?php echo $value;?>" />
									<?php endforeach;?>
								</form>
							</div>
							<div class="custom-search">
								<div class="search-heading">Total Jobs</div>
								<div class="grid">
								<table style="width:100%" class="widefat">
									<thead>
										<tr>
											<?php $columns = $this->get_columns();?> 
											<?php foreach($columns  as $key=>$value):?>
												<th><?php echo $value;  ?></th>
											<?php endforeach; ?>
										</tr>
									</thead>
									<?php foreach($jobs  as $k=>$v):?> 
									<tr>
										<tbody>
										<?php foreach($columns  as $key=>$value):?>
												<td><?php echo  $v->$key ?></td>
										 <?php endforeach; ?>
										 </tbody>
								   </tr> 	
								   <?php endforeach; ?>
								</table>		
								</div>
							</div>
						</div>				
					</div>
				</div>
				
				<div class="icjm_pagination">
					<form id="job_pagination_form" class="<?php echo $admin_page ;?>_form" action="<?php echo $targetpage;?>" method="post">
						<?php foreach($_REQUEST as $key => $value):?>
							<input type="<?php echo $type ?>" name="<?php echo $key;?>" value="<?php echo $value;?>" />
						<?php endforeach;?>
					</form>
				<?php
				$count = $this->get_icjm_jobs_query("count");
				echo $this->get_pagination($count,3) . "</div>";
			}
			
		}
		function get_toatal_status(){
			$count = 0;
			$result = $this->get_icjm_post_type("icjm_job_status");
			$result = $this->get_icjm_post_type("icjm_job_category");
			$result = $this->get_icjm_post_type("icjm_job_location");
			$result = $this->get_icjm_post_type("icjm_job_type");
			$result = $this->get_icjm_post_type("icjm_job_position");
			$result = $this->get_icjm_post_type("icjm_job_company");
			//$this->print_array($result);
			$count  =count($result );
			return $count;
		}
		function get_columns(){
			$columns = array();
			$columns["post_date"] 				= "Created Date";
			$columns["post_title"] 				= "Job Title";
			$columns["icjm_job_status_label"] 	= "Status";	
			$columns["icjm_job_category_label"] 	= "Category";	
			$columns["icjm_job_location_label"] 	= "Location";	
			$columns["icjm_job_position_label"] 	= "Position";	
			$columns["icjm_job_company_label"] 	= "Company";	
			$columns["icjm_job_type_label"] 		= "Type";	
			$columns["icjm_job_salary"] 			= "Salary";
			$columns["icjm_job_expired_date"] 	= " Expired Date";	
			return $columns; 
		}
		function export_job($file_name,$file_format)
		{
			
			  $columns = $this->get_columns();
			  $rows =$this->get_icjm_post_meta("export");
			  //$this->print_data(  $rows);
			  $i = 0;
			$export_rows = array();
			foreach ( $rows as $rkey => $rvalue ):	
					foreach($columns as $key => $value):
						switch ($key) {
							case "order_status":
								$export_rows[$i][$key] = ucfirst ( str_replace("wc-","",   $rvalue->$key));
								break;
							case "billing_country":
								$export_rows[$i][$key] = $this->get_country_name($rvalue->billing_country);
								break;	
							default:
								$export_rows[$i][$key] = isset($rvalue->$key) ? $rvalue->$key : '';
								break;
				}
					endforeach;
					$i++;
			endforeach;
			$this->ExportToCsv($file_name ,$export_rows,$columns,$file_format); 
			//die;
		}
	}
}
?>