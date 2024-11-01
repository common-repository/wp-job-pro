<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! class_exists( 'icjm_save_job_application' ) ) { 
	class icjm_save_job_application{
	
		function icjm_save_job(){
			$message =array();
			$message["status"] = 0;
			$message["message"] = "Not apply for this job";
			//echo json_encode($_REQUEST["post_id"]);
			$post_id = isset($_REQUEST["post_id"])?$_REQUEST["post_id"] :0;
			
			$first_name 		= isset($_REQUEST["first_name"])?$_REQUEST["first_name"] :'';
			$last_name 		 = isset($_REQUEST["last_name"])?$_REQUEST["last_name"] :'';
			$email_address 	 = isset($_REQUEST["email_address"])?$_REQUEST["email_address"] :'';
			$contact_no 		= isset($_REQUEST["contact_no"])?$_REQUEST["contact_no"] :'';
			$about_yourself	= isset($_REQUEST["about_yourself"])?$_REQUEST["about_yourself"] :'';
			
			
			$row = $this->icjm_get_job($post_id );
			
			$post_data = array(
				'post_title'	  =>$row[0]->post_title, 
				'post_type'	   =>'icjm_job_application', 
				'post_status'     => 'publish',
				'comment-status'  => 'closed',
				'ping-status'     => 'closed',
				'post_author'     => 1,
				'post_content'	=>'',
			);
			
			 $job_application_post_id = wp_insert_post($post_data);
			
			 update_post_meta( $job_application_post_id, '_first_name', 	$first_name );
			 update_post_meta( $job_application_post_id, '_last_name', 		$last_name );
			 update_post_meta( $job_application_post_id, '_email_address', 	$email_address );
			 update_post_meta( $job_application_post_id, '_contact_no', 	$contact_no );
			 update_post_meta( $job_application_post_id, '_about_yourself', $about_yourself );
			 update_post_meta( $job_application_post_id, '_job_post_id', 	$post_id );
			 
			 update_post_meta( $job_application_post_id, '_icjm_job_company_label', $row[0]->icjm_job_company_label );
			 update_post_meta( $job_application_post_id, '_icjm_job_company_id', $row[0]->icjm_job_company_id );
			 
			 
			
			 //json_encode($row[0]->post_title);
			 if ( $job_application_post_id>0){
				$message["status"] = 1;
				$message["message"] = "You have successfully apply for this job";
				$this->send_email();
			 }
			 echo json_encode($message);
		}
		
		function icjm_get_job($post_id){
			global $wpdb;
			$query = "";
			$query = " SELECT "; 
			$query .=" posts.post_title as post_title"; 
			
			$query .=" ,icjm_job_company_label.meta_value as icjm_job_company_label"; 
			$query .=" ,icjm_job_company_id.meta_value as icjm_job_company_id";
			 
			$query .=" FROM  {$wpdb->prefix}posts as posts "; 
			
			$query .=" LEFT JOIN  {$wpdb->prefix}postmeta as icjm_job_company_label ON icjm_job_company_label.post_id=posts.ID ";
			
			$query .=" LEFT JOIN  {$wpdb->prefix}postmeta as icjm_job_company_id ON icjm_job_company_id.post_id=posts.ID ";
			
			$query .= " WHERE 1=1 ";   
			$query .= " AND posts.post_type = 'icjm_job'"; 
			$query .= " AND posts.post_status='publish'";
			$query .= " AND posts.id='{$post_id}'";
			
			$query .= " AND icjm_job_company_label.meta_key='_icjm_job_company_label'";
			$query .= " AND icjm_job_company_id.meta_key='_icjm_job_company_id'";			
			
		 	return	$row = $wpdb->get_results( $query);	
		}
		
		function send_email(){
			
			//$email_address 	 = isset($_REQUEST["email_address"])?$_REQUEST["email_address"] :'';
			$post_id 		   = isset($_REQUEST["post_id"])?$_REQUEST["post_id"] :0;
			$row = $this->icjm_get_job($post_id );
			
			$company_post_id = 	$row[0]->icjm_job_company_id;
			
			$company_email_address =   get_post_meta($company_post_id , '_icjm_company_email',true ) ;
			if (!filter_var($company_email_address, FILTER_VALIDATE_EMAIL)) {
				return ;
			}
			
			
				
			ob_start();	
			$output = ob_get_contents();
			$this->get_email_content();
			$output = ob_get_contents();
			ob_end_clean();
			
			
			$to = $company_email_address;
			$subject = "Job Application";
			$message = 	$output;
			
			
			$headers =  array();
			$headers[] = 'Content-Type: text/html; charset=UTF-8';
			if ($from)
				$headers[] = 'From:  <' .$from. '>';
				$status = wp_mail($to, $subject, $message, $headers);
			/*
			if ($status){
				echo "Message has been sent";
			}else{
				echo "Message was not sent";
			}
			*/
		}
		
		function get_email_content(){
			$post_id 		   = isset($_REQUEST["post_id"])?$_REQUEST["post_id"] :0;
			$first_name 		= isset($_REQUEST["first_name"])?$_REQUEST["first_name"] :'';
			$last_name 		 = isset($_REQUEST["last_name"])?$_REQUEST["last_name"] :'';
			$email_address 	 = isset($_REQUEST["email_address"])?$_REQUEST["email_address"] :'';
			$contact_no 		= isset($_REQUEST["contact_no"])?$_REQUEST["contact_no"] :'';
			$about_yourself	= isset($_REQUEST["about_yourself"])?$_REQUEST["about_yourself"] :'';
			
			$row = $this->icjm_get_job($post_id );
			
			?>
            <table>
            	<tr>
                	<td>Job title</td>
                    <td><?php echo $row[0]->post_title; ?></td>
                </tr>
                <tr>
                	<td>First Name</td>
                    <td><?php echo $first_name; ?></td>
                </tr>
                <tr>
                	<td>Last Name</td>
                    <td><?php echo $last_name; ?></td>
                </tr>
                <tr>
                	<td>Email Address</td>
                    <td><?php echo $email_address; ?></td>
                </tr>
                <tr>
                	<td>Contact No</td>
                    <td><?php echo $contact_no; ?></td>
                </tr>
                <tr>
                	<td>About Yourself</td>
                    <td><?php echo $about_yourself; ?></td>
                </tr>
            </table>
            <?php
			
			
		}
	}
}
?>