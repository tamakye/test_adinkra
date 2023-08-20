	$('#blogTable').DataTable();
	
	$(function(){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
			}
		})



		$(document).on('click', '.blog_actions', function(e){
			e.preventDefault();
			let status = $(this).data('status');
			let slug = $(this).data('slug');
			$('#blog_status').val(status);
			$('#blog_slug').val(slug);

			$('.action_to_perfom').html(status);
			$('.blodModal').modal('show');
		})

		$(document).on('click', '#proceedBlogAction', function(e){
			e.preventDefault();
			let status = $('#blog_status').val();
			let slug = $('#blog_slug').val();

			$.post('/dashboard/blog/actions', {status: status, slug, slug}, function(data){
				$('#blogTable').load(location.href + ' #blogTable');
				toastr.success(data.success);
				$('.blodModal').modal('hide');
			});


		})


		$(document).on('click', '.save_draft', function(e){
			e.preventDefault();
			$('#status').val('draft');
			$('#blogForm').submit();
		})

		$(document).on('click', '.save_publish', function(e){
			e.preventDefault();
			$('#status').val('publish');
			$('#blogForm').submit();
		})


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