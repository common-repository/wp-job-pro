// JavaScript Document
jQuery(function($){
	
	
	
	$("#frm_job_search").submit(function(e) {
		//alert(icjm_job_ajax_object.icjm_job_ajax_url);
		//alert($("#frm_job_search").serialize())
		//return false;		
		$.ajax({
			url:icjm_job_ajax_object.icjm_job_ajax_url,
			//url:$("#icjm_job_ajax_url").val(),
			data:$("#frm_job_search").serialize(),
			success:function(data) {
				// This outputs the result of the ajax request
				//alert(data);
				//console.log(data);
				//var obj = JSON.parse(data);
				//alert("s");
				$(".ajax_content").html(data);
			},
			error: function(errorThrown){
				console.log(errorThrown);
				alert("e");
			}
		}); 
		e.preventDefault(); // avoid to execute the actual submit of the form.
	});
	/*
	$( "#_icjm_job_status" ).change(function() {
	 	 //alert( $(this).text());
		 var selectedText = $(this).find("option:selected").text();
         var selectedValue = $(this).val();
         //alert("Selected Text: " + selectedText + " Value: " + selectedValue);
	});
	
	$( "._dropdown" ).change(function() {
		 
		 var selectedText = $(this).find("option:selected").text();
         var selectedValue = $(this).val();
		 var id = $(this).attr("id");
		 
		 $("#"+id+"_label").val(selectedText);
		 //alert("ID " + id  + " Selected Text: " + selectedText + " Value: " + selectedValue);
		 
	});
	
	
		//_job_details_meta_box
     	//var icjm_job_status = $("#_icjm_job_status option:selected").text();
	 	//$("#_icjm_label_job_status").val(icjm_job_status);
		
		$('._job_details_meta_box td').each(function (index, value) { 
			alert("asdsadas");
		});
		
    */
	
	$("#frm_job_search").trigger("submit");
	$(document).on("click",".pagination a", function(){
	
		//alert("a");
		
		
		var p = $(this).attr("data-p");
		//alert(p);
		
		
		$("#frm_job_search").find("input[name=p]").val(p);
		
	//	return false;
		$("#frm_job_search").submit();
		//$("#frm_job_search").trigger("submit");
		return false
	});

	/*Popup JS*/
	$('[data-popup-open]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-open');
        $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
 		clear_form();
        e.preventDefault();
    });
 
    //----- CLOSE
    $('[data-popup-close]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
 
        e.preventDefault();
    });
	/*End Popup JS*/
	$(".alert").hide();
	/*Apply Button Click*/
	$("#btnApply").click(function(e){
		if (is_valid()){
			//alert(icjm_job_ajax_object.icjm_job_ajax_url);
			jQuery(".icjm_application_message").show();	
			MessageAddClass(".icjm_application_message","alert-info");	
			jQuery(".icjm_application_message").html("Please wait..");
		
			$.ajax({
			url:icjm_job_ajax_object.icjm_job_ajax_url,
			//url:$("#ni_ajax_url").val(),
			data:$("#frm_job_apply").serialize(),
			success:function(data) {
				var obj = JSON.parse(data);
				if (obj.status==1){
					//alert(obj.message);
					jQuery(".icjm_application_message").html(obj.message);
					MessageAddClass(".icjm_application_message","alert-success");	
					
					setTimeout(function() { 
							$('[data-popup-close]').click();
							$(".alert").hide();
					}, 3000);
				}
				else if (obj.status==0) {
					jQuery(".icjm_application_message").html(obj.message);
					MessageAddClass(".icjm_application_message","alert-danger");	
					//alert("SUCCESS");
					setTimeout(function() { 
							$('[data-popup-close]').click();
					}, 3000);
				}else{
					jQuery(".icjm_application_message").html(data);
					setTimeout(function() { 
							$('[data-popup-close]').click();
						}, 3000);
				}
				//alert(JSON.stringify(data));
			},
			error: function(errorThrown){
				console.log(errorThrown);
				alert("e");
			}
		});
		}
		else{
			jQuery(".icjm_application_message").show();	
			MessageAddClass(".icjm_application_message","alert-danger");	
			jQuery(".icjm_application_message").html("Required fields are marked in red");	
		}
		e.preventDefault();
	});
	/*End Apply Button Click*/

});
var valid = false;
function is_valid(){
		valid =true;
		
		/*First Name*/
		if ( jQuery.trim( jQuery( "#first_name" ).val()) == "") {
			jQuery( "#first_name" ).addClass( "error_message" );
			valid = false;
		}else{
			//hasClass
			if (jQuery("#first_name" ).hasClass("error_message"))
			jQuery( "#first_name" ).removeClass( "error_message" );
		}
		
		/*Last Name*/
		if ( jQuery.trim( jQuery( "#last_name" ).val()) == "") {
			jQuery( "#last_name" ).addClass( "error_message" );
			valid = false;
		}else{
			//hasClass
			if (jQuery("#last_name" ).hasClass("error_message"))
			jQuery( "#last_name" ).removeClass( "error_message" );
		}
		
		
		
		
		/*Email Address*/
		if ( jQuery.trim( jQuery( "#email_address" ).val()) == "") {
			jQuery( "#email_address" ).addClass( "error_message" );
			valid = false;
		}else{
			
			if (!isEmail(jQuery.trim( jQuery( "#email_address" ).val()))) {
				jQuery( "#email_address" ).addClass( "error_message" );
				valid = false;
			}else{
				//hasClass
				if (jQuery("#email_address" ).hasClass("error_message"))
				jQuery( "#email_address" ).removeClass( "error_message" );
			}
			
		}
		
		/*Contact Number*/
		if ( jQuery.trim( jQuery( "#contact_no" ).val()) == "") {
			jQuery( "#contact_no" ).addClass( "error_message" );
			valid = false;
		}else{
			//hasClass
			if (jQuery("#contact_no" ).hasClass("error_message"))
			jQuery( "#contact_no" ).removeClass( "error_message" );
		}
		
		/*Enquiry Description*/
		if ( jQuery.trim( jQuery( "#about_yourself" ).val()) == "") {
			jQuery( "#about_yourself" ).addClass( "error_message" );
			valid = false;
		}else{
			//hasClass
			if (jQuery("#about_yourself" ).hasClass("error_message"))
			jQuery( "#about_yourself" ).removeClass( "error_message" );
		}
		//alert(valid);
		return valid;
	}
	function isEmail(email) {
	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}
	function MessageAddClass(object_name, class_name){
		if (jQuery(object_name ).hasClass( "alert-error" ))
			jQuery( object_name ).removeClass( "alert-error" );
			
		if (jQuery(object_name ).hasClass( "alert-danger" ))
			jQuery( object_name ).removeClass( "alert-danger" );	
		
		if (jQuery(object_name ).hasClass("alert-success" ))
			jQuery( object_name ).removeClass( "alert-success" );
			
		if (jQuery(object_name ).hasClass("alert-info"))
			jQuery( object_name ).removeClass( "alert-info" );
			
			
		jQuery( object_name).addClass( class_name );	
	}
	function clear_form(){
		jQuery( "#first_name" ).val('');
		jQuery( "#last_name" ).val('');
		jQuery( "#email_address" ).val('');
		jQuery( "#contact_no" ).val('');
		jQuery( "#about_yourself" ).val('');
		jQuery(".icjm_application_message").html("");
		jQuery(".alert").html("");
		
		jQuery("#first_name" ).removeClass( "error_message" );
		jQuery("#last_name" ).removeClass( "error_message" );
		jQuery("#email_address" ).removeClass( "error_message" );
		jQuery("#contact_no" ).removeClass( "error_message" );
		jQuery("#about_yourself" ).removeClass( "error_message" );
	//	jQuery(  "#about_yourself" ).removeClass( "alert-danger" );
		
		
		
	}