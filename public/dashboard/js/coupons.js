$(function(){

	$.ajaxSetup({
		headers: {
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
		}
	})

	$('#couponTable').DataTable();

	$(document).on('click', '.generate-coupon', function(){
		$('.refresh-coupon').load(location.href + ' .refresh-coupon');	
	})

	$(document).on('click', '#unlimited', function(){
		
		if ($(this).is(':checked')) {
			$('.show-quantity').attr('disabled', 'disabled').hide();
		}else{
			$('.show-quantity').removeAttr('disabled').show();

		}
	})


	$(document).on('change', '#apply_on', function(){
		
		if ($(this).val() == 'all_orders') {
			$('.apply_on_fields').attr('hidden', 'hidden');
		}else if($(this).val() == 'order_amount'){
			$('.apply_on_fields').attr('hidden', 'hidden');
			$('#order_amount').removeAttr('hidden');
		}else if($(this).val() == 'product'){
			$('.apply_on_fields').attr('hidden', 'hidden');
			$('#order_product').removeAttr('hidden');
		}else if($(this).val() == 'categories'){
			$('.apply_on_fields').attr('hidden', 'hidden');
			$('#order_category').removeAttr('hidden');
		}else if($(this).val() == 'user'){
			$('.apply_on_fields').attr('hidden', 'hidden');
			$('#user').removeAttr('hidden');
		}
	})


	$('.datepicker').datetimepicker();

	$(document).on('click', '#expires', function(){
		
		if ($(this).is(':checked')) {
			$('#end_date').attr('disabled', 'disabled').removeAttr('required', 'required');
		}else{
			$('#end_date').removeAttr('disabled').attr('required', 'required');

		}
	})

	$(document).on('click', '.delete-coupon', function(){
		$('.coupon-value').html($(this).data('coupon'));
		$('#deleteModal').modal('show');
	})


	$(document).on('click', '.proceed-delete', function(){
		let btn = $(this);
		let coupon = $('.coupon-value').html();
		btn.html('Deleting...').attr('disabled', 'disabled');
		
		$.post('/dashboard/coupons/delete', {coupon: coupon}, function(data){
			if (data.success) {
				$('#couponTable').load(location.href + ' #couponTable');	
				toastr.success(data.success);
				btn.html('Proceed!').removeAttr('disabled');
				$('#deleteModal').modal('hide');
			}else{
				toastr.error('An error occured. Try again.');
				btn.html('Proceed!').removeAttr('disabled');
			}
		})
	})	
})