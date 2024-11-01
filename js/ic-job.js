// JavaScript Document
var post_type 		= "";
var post_return		= true;
var msg			 	= "";

jQuery(function($){
	
	/*Color*/
	$('._icjm_color-field').wpColorPicker();
    
	
	$("._icjm_message_row").hide();
	
	jQuery('._date').datepicker({
        dateFormat : 'yy-mm-dd'
    });
	
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
		 //var icjm_job_status = $("#_icjm_job_status option:selected").text();
	 	//$("#_icjm_label_job_status").val(icjm_job_status);
		
		$('#_job_details_meta_box ._dropdown_td select').each(function (index, element) { 
			//alert($(this).html());
			//alert(element);
			var label = $(element).find("option:selected").text();
			var id = $(element).attr("id");
			//alert(label  +" " + id);
			
			 $("#"+id+"_label").val(label);
			
			//var icjm_job_status = $(this).("option:selected").text();
		//	alert(icjm_job_status);
			
		});
		/*On Post Submit*/
		
		$( "#post" ).submit(function( event ) {
  			
			post_type = $("#post_type").val();
			msg = "";
			
			if (post_type=="icjm_job"){
				
				
				if ($("#_icjm_job_status").val() == "-1"){
					//alert("Select Status");
					msg += " Select Job Status ";
					$("#_icjm_job_status").addClass("icjm_error_border");
					//error_border
				}else{
					if ($("#_icjm_job_status").hasClass('icjm_error_border')){
						$("#_icjm_job_status").removeClass("icjm_error_border");
					}
				}
				if ($("#_icjm_job_category").val() == "-1"){
					//alert("Select Status");
					msg += " Select Job Category ";
					$("#_icjm_job_category").addClass("icjm_error_border");
					//error_border
				}else{
					if ($("#_icjm_job_category").hasClass('icjm_error_border')){
						$("#_icjm_job_category").removeClass("icjm_error_border");
					}
				}
				/*Location*/
				if ($("#_icjm_job_location").val() == "-1"){
					//alert("Select Status");
					msg += " Select Job Location ";
					$("#_icjm_job_location").addClass("icjm_error_border");
					//error_border
				}else{
					if ($("#_icjm_job_location").hasClass('icjm_error_border')){
						$("#_icjm_job_location").removeClass("icjm_error_border");
					}
				}
				/*Type*/
				if ($("#_icjm_job_type").val() == "-1"){
					//alert("Select Status");
					msg += " Select Job Type ";
					$("#_icjm_job_type").addClass("icjm_error_border");
					//error_border
				}else{
					if ($("#_icjm_job_type").hasClass('icjm_error_border')){
						$("#_icjm_job_type").removeClass("icjm_error_border");
					}
				}
				/*Position*/
				if ($("#_icjm_job_position").val() == "-1"){
					//alert("Select Status");
					msg += " Select Job Position ";
					$("#_icjm_job_position").addClass("icjm_error_border");
					//error_border
				}else{
					if ($("#_icjm_job_position").hasClass('icjm_error_border')){
						$("#_icjm_job_position").removeClass("icjm_error_border");
					}
				}
				/*Company*/
				if ($("#_icjm_job_company").val() == "-1"){
					//alert("Select Status");
					msg += " Select Job Company ";
					$("#_icjm_job_company").addClass("icjm_error_border");
					//error_border
				}else{
					if ($("#_icjm_job_company").hasClass('icjm_error_border')){
						$("#_icjm_job_company").removeClass("icjm_error_border");
					}
				}
				if (msg.length==0){
					$("._icjm_message_row").hide();
					post_return = true;
					
				}else{
					
					$("._icjm_message_row").show();
					$("._icjm_message_row").html("Required fields are marked in red");
					post_return = false;
				}
				
				
				//alert($("#_icjm_job_status").val());	
									
			}
			//console.log(event);
			//alert(event);
			//alert( "Handler for .submit() called." );
			
			//alert($("#post_type").val());
			
  			//event.preventDefault();
			return post_return;
		});
				
	
});