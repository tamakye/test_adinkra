$(function(){
		// select and preview founder
		$(document).on('change', "#thumbnail", function(){

			if (checkFile($(this).val())) {

				let reader = new FileReader();
				reader.onload = (e) => { 
					$('#image_preview').show().attr('src', e.target.result).css({'width':'300px'}); 
				}

				reader.readAsDataURL(this.files[0]); 
			}else{
				$(this).val('');
				toastr.error('File is not an image. Only png, jpg and jpeg images are supported');
			}
		})



	// check image upload
	function checkFile(val){
		let valid;
		switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
			case 'jpeg': case 'jpg': case 'png':
			valid =  true;
			break;

			default:
			valid = false;
			break;
		}

		return valid;
	}
})