/* Upload Images Script */
$(document).on("change",".coverimage", function(){
	var uploadFile = $(this);
    var files = !!this.files ? this.files : [];
    if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
			//alert(files[0].type);
    if (/^image/.test( files[0].type)){ // only image file
        var reader = new FileReader(); // instance of the FileReader
        reader.readAsDataURL(files[0]); // read the local file

        reader.onloadend = function(){ // set image data as background of div
            //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
        uploadFile.closest("tr").find('.imagePreview').css("background-image", "url("+this.result+")").show();
        }
    }
});


$(document).ready(function(){ 
  $("#userlogin").submit(function(){
  		$('#userlogin .form-group').removeClass('has-error');
  		$('#userlogin .help-block').html('');
  		 $.ajax({
	        url: '/',
	        type: 'post',
	        dataType: 'json',
	        data: $(this).serialize(),
	        success: function(response) {
	           	var i = 1;
	           	if(response.error){
	           		jQuery.each( response.data, function( index, value ) {
					  	if(value!=''){
					  		$('#Input'+index).addClass('has-error');
					  		$('#Input'+index+' .help-block').html(value);
					  		if(i==1){	
					  			$('#'+index).focus();
					  		}
					  		i++;
					  	}
					});					 
	           	}else{
	           		/*console.log('dsad '+response);
	           		return false;*/
	           		//$(this).submit();
	           		window.location.href = response.url;
	           	}
	        }
	    });
  		return false;	
  });	
});



/* Add User Script */
$(document).ready(function(){ 
  $("#adduser").submit(function(){
  		$('#adduser .form-group').removeClass('has-error');
  		$('#adduser .help-block').html('');

  		$.ajax({
	        url: 'adduservalidation',
	        type: 'post',
	        dataType: 'json',
	        data: new FormData(this),
	        contentType:false,
            cache:false,
            processData:false,
	        success: function(response) {
	           	var i = 1;
	           	if(response.error){
	           		jQuery.each( response.data, function( index, value ) {
					  	if(value!=''){
					  		$('#Input'+index).addClass('has-error');
					  		$('#Input'+index+' .help-block').html(value);
					  		if(i==1){	
					  			$('#'+index).focus();
					  		}
					  		i++;
					  	}
					});					 
	           	}else{
	           		//$(this).submit();
	           		window.location.href = response.url;
	           	}
	        }
	    });
  		return false;	
  });	
});

/* Update User Script */
$(document).ready(function(){ 
  $("#update_user").submit(function(){

  		$('#update_user .form-group').removeClass('has-error');
  		$('#update_user .help-block').html('');
  		 $.ajax({
	        url: 'updateuservalidation',
	        type: 'post',
	        dataType: 'json',
	        data: new FormData(this),
	        contentType:false,
            cache:false,
            processData:false,
	        success: function(response) {
	           	var i = 1;
	           	if(response.error){
	           		jQuery.each( response.data, function( index, value ) {
					  	if(value!=''){
					  		$('#Input'+index).addClass('has-error');
					  		$('#Input'+index+' .help-block').html(value);
					  		if(i==1){	
					  			$('#'+index).focus();
					  		}
					  		i++;
					  	}
					});					 
	           	}else {
	           		$('#successs_msg').show();
	           		$('#successs_msg').fadeOut(6000);
              		$('html, body').animate({ scrollTop: $("#successs_msg").offset().top-90 }, 2500);
              		var explode = function(){
		               location.reload();
		            }
		            setTimeout(explode, 1000);
	           	}
	        }
	    });
  		return false;	
  });	
});

/* Close Update User Message Script */
$(document).ready(function(){
    $('#close_btn').click(function(){
           $('#successs_msg').hide();
        }
    );
});


$(document).ready(function(){
    $('#check_password').click(function(){
           if($(this).prop("checked") == true){
                $('#Inputoldpassword').show();
                $('#Inputnewpassword').show();
                $('#Inputconfirmpassword').show();
            }
            else if($(this).prop("checked") == false){
                $('#Inputoldpassword').hide();
                $('#Inputnewpassword').hide();
                $('#Inputconfirmpassword').hide();
            }
        }
    );
});