$(function(){

	$.ajaxSetup({
		headers: {
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
		}
	});
	
	$(document).on('click', '.view_order', function(){

		let slug = $(this).data('slug');
		// console(slug);
		$("#loadingoverlay").fadeIn();
		
		$.post('/dashboard/fetch-order', {slug: slug}, function(data){

			$('.order-modal-content').html(data);

			setTimeout(function(){
				$("#loadingoverlay").fadeOut();
				$('#orderModal').modal('show');
			}, 1000);
		})
	})	


	// check a single payment
	$(document).on('click', '.single_check', function(){

		if ($(this).is(':checked')) {
			$('#bulkAction').removeAttr('disabled');
			$('#apply_button').removeAttr('disabled');
			$('#checkAll').prop('checked', true);

		}else if(checkedRequest()){
			$('#bulkAction').removeAttr('disabled');
			$('#apply_button').removeAttr('disabled');
			$('#checkAll').prop('checked', true);
		}else{
			$('#bulkAction').attr('disabled', 'disabled');
			$('#apply_button').attr('disabled', 'disabled');
			$('#checkAll').prop('checked', false);
		}
	})

	// check all
	$(document).on('click', '#checkAll', function(){
		if ($(this).is(':checked')) {
			$('#bulkAction').removeAttr('disabled');
			$('#apply_button').removeAttr('disabled');
			$('.single_check').prop('checked', true);
			
		}else{
			$('#bulkAction').attr('disabled', 'disabled');
			$('#apply_button').attr('disabled', 'disabled');
			$('.single_check').prop('checked', false);
			$(this).prop('checked', false);
		}
	})


	

	// update single order order
	$(document).on('click', '.update_order', function(){
		let orders = $('#order').val();

		let status = $(this).data('status');
		$(this).html('<i class="fas fa-spinner fa-spin"></i>').css('width', '6.5rem').attr('disabled');
		$.post('/dashboard/update-order', {orders: orders, status: status, type: 'single'}, function(data){
			
			toastr.success(data.success);
			window.location.reload();
		})
	})

	// update bulk orders
	$(document).on('click', '#apply_button', function(){

		let status = $('.bulk_order_update option:selected').data('status');
		// let status = $('.bulk_order_update option:selected').val();
		let orders = pushCheckedItemsToArray();


		if (orders && orders.length) {

			$("#loadingoverlay").fadeIn();

			$.post('/dashboard/update-order', {orders: orders, status: status, type: 'bulk'}, function(data){

				setTimeout(function(){
					$("#loadingoverlay").fadeOut();
					$('#orderModal').modal('show');
				}, 500);
				toastr.success(data.success);
				window.location.reload();
			})

		}else{
			toastr.error('Select an item to proceed!');
			return false;
			
		}

		
	})

	// count all checked item
	function checkedRequest(){
		let total = $('.single_check').is(':checked');
		let valid = false;

		if (total > 0) {
			valid = true;
		}

		return valid;
	}

	function pushCheckedItemsToArray(){
		let orders = [];

		$(".single_check:checked").each(function () {
			orders.push($(this).data('order'));
		});

		let single  = $(this).data('order') ?? '';

		if (single !=  '') {
			orders.push(single);
		}

		orders = JSON.stringify( orders );

		// $('#orders').val(orders);
		return orders;
	}


	// empty bin
	$(document).on('click', '#empty_bin', function(){

		$("#loadingoverlay").fadeIn();

		$.post('/dashboard/empty-bin',function(data){

			if (data.success) {
				setTimeout(function(){
					$("#loadingoverlay").fadeOut();
				}, 500);
				toastr.success(data.success);
				window.location.reload();
			}else{
				toastr.error(data.error);
				$("#loadingoverlay").fadeOut();
			}
		});

		
	})

	// enable submit button
	$(document).on('keyup', '#search_input', function(){
		if ($(this).val() == '') {
			toastr.error('Input can not be empty');
			$('#search_button').attr('disabled', 'disabled');
		}else{
			$('#search_button').removeAttr('disabled');
		}
	})


	// show 
	$(document).on('change', '#billing_country', function(e){

		let country = $(this).val();

		$.post('/country/fetch-regions', {country: country}, function(data){

			let options = ['<option selected hidden disabled value="">Choose region</option>'];
			if (data.length > 0) {
				$.each(data, function(key, item){
					let option = '<option value="'+item.id+'">'+item.name+'</option>';
					options.push(option);
				})

				$('.billing_region_input').attr('disabled', 'disabled').hide();
				$('#billing_region').html('').append(options);
				$('.billing_region_select').removeAttr('disabled').show().select2();

			}else{
				$('.billing_region_select').select2().attr('disabled', 'disabled').select2('destroy').hide();
				$('.billing_region_input').val('').removeAttr('disabled').attr('placeholder', 'Enter region').show();
			}
		}, 'json')

	})

	$(document).on('change', '#shipping_country', function(e){

		let country = $(this).val();
		$.post('/country/fetch-regions', {country: country}, function(data){

			let options = ['<option selected hidden disabled value="">Choose region</option>'];
			if (data.length > 0) {
				$.each(data, function(key, item){
					let option = '<option value="'+item.id+'">'+item.name+'</option>';
					options.push(option);
				})

				$('.shipping_region_input').attr('disabled', 'disabled').hide();
				$('#shipping_region').html('').append(options);
				$('.shipping_region_select').removeAttr('disabled').show().select2();

			}else{
				$('.shipping_region_select').select2().attr('disabled', 'disabled').select2('destroy').hide();
				$('.shipping_region_input').val('').removeAttr('disabled').attr('placeholder', 'Enter region').show();
			}
		}, 'json')

	})


	// show billing address
	$(document).on('click', '.edit_billing_address', function(){
		$('#billing_address_group, #billing_info').toggle();
	})

	// show billing address
	$(document).on('click', '.edit_shipping_address', function(){
		$('#shipping_address_group, #shipping_info').toggle();
	})

	// empty product modal
	$(document).on('click', '.add_product', function(){
		$(".product").val('');
		$(".product_quantity").val('');
		$('#productModal').modal('show');
	})


	// add products to orders
	$(document).on('click', '.add_product_to_order', function(){

		$("#loadingoverlay").fadeIn();
		
		$.post('/dashboard/orders/add-product', $('.addProductForm').serialize(), function(data){
			
			if (data.success) {
				refreshItems();
				toastr.success(data.success);

				setTimeout(function(){
					$("#loadingoverlay").fadeOut();
					$('#productModal').modal('hide');
				}, 500);

			}else{

				toastr.error(data.error);
			}

		}, 'json')
	})	


	// update basket
	$(document).on('click', '.update_product', function(e){
		e.preventDefault();

		let quantity = [];
		let items = [];
		$(".basket_quantity").map(function(){
			quantity.push($(this).val());
		}).get();

		$(".items").map(function(){
			items.push($(this).val());
		}).get();

		items = JSON.stringify( items );
		quantity = JSON.stringify( quantity );

		let formData = new FormData();
		formData.append('quantity', quantity);
		formData.append('items', items);
		formData.append('order_number', $('#order_number').val());

		let button = $(this);
		button.html('<i class="fas fa-spin fa-spinner"></i> Updating')

		$.ajax({
			url: '/dashboard/orders/update-product',
			data: formData,
			processData: false,
			contentType: false,
			type: 'POST',
			success: function(data){

				if (data.success) {
					refreshItems();
					toastr.success(data.success);
					button.html('Update')

				}else{
					button.html('Update')
					toastr.error(data.error);
				}
			}
		});

	})


	// remove product
	$(document).on('click', '.remove_item', function(e){
		let item_id = $(this).data('item');
		let order_number = $('#order_number').val();
		$.post('/dashboard/orders/remove-product', {item_id: item_id, order_number: order_number}, function(data){

			if (data.success) {
				refreshItems();
				toastr.success(data.success);
				
			}else{
				toastr.error(data.error);
			}
		})

	})


	//add tax
	$(document).on('click', '.add_tax', function(e){
		let tax = $('.order_tax:checked').val();
		let order_number = $('#order_number').val();

		$.post('/dashboard/orders/add-tax', {tax: tax, order_number: order_number}, function(data){

			if (data.success) {
				refreshItems();
				toastr.success(data.success);
				$('#taxModal').modal('hide');
				
			}else{
				toastr.error(data.error);
			}
		})

	})

	$(document).on('click', '.remove_tax', function(e){

		let order_number = $('#order_number').val();

		$.post('/dashboard/orders/remove-tax', {order_number: order_number}, function(data){

			if (data.success) {
				refreshItems();
				toastr.success(data.success);
				
			}else{
				toastr.error(data.error);
			}
		})

	})	

	function refreshItems(){

		$('#orderProductTable').load(location.href + ' #orderProductTable');
		$('.reload-total').load(location.href + ' .reload-total');

	}	


	// submit order
	$(document).on('click', '.create_order', function(e){

		if (!validate()) {
			toastr.error('Any highlighted field if required');
			return false;
		}

		document.getElementById('orderForm').submit();
	})
	

	function validate(){
		let valid = true;

		if ($('.product_content').val() <= 0) {
			valid = false;
			toastr.error('Add a product before continuing');
		}else if($('#order_date').val() == '' || $('#order_date').val() == null){
			valid = false;
			$('.order_date').addClass('is-invalid');
		}else{

			let input = $('.required');
			for (var i = 0; i < input.length; i++) {
				if (input[i].value == '') {
					input[i].classList += ' is-invalid';
					valid = false;
				}
			}
		}

		return valid;

	}

	// load_billing_address
	$(document).on('click', '.load_billing_address', function(e){

		let get_status = $('#customer option:selected').data('status');

		let status = get_status == '' || get_status == null ? 'user' : get_status;

		let customer = $('#customer option:selected').val();

		let confirmed = confirm('Load the customer\'s billing information? This will remove any currently entered billing information.')
		
		if (confirmed) {

			if (customer == 'guest') {
				toastr.error('No customer selected');
			}else{

				$.post('/dashboard/load-customer-address', {customer: customer, status: status, address_type: 'billing'}, function(data){
					populateForm(data);
				})

			}
		}
		

	})

	// load_shipping_address
	$(document).on('click', '.load_shipping_address', function(e){

		let get_status = $('#customer option:selected').data('status');

		let status = get_status == '' || get_status == null ? 'user' : get_status;

		let customer = $('#customer option:selected').val();

		let confirmed = confirm('Load the customer\'s shipping information? This will remove any currently entered shipping information.')
		
		if (confirmed) {

			if (customer == 'guest') {
				toastr.error('No customer selected');
			}else{

				$.post('/dashboard/load-customer-address', {customer: customer, status: status, address_type: 'shipping'}, function(data){
					populateForm(data);
				})

			}
		}

	})

	// copy_billing_address
	$(document).on('click', '.copy_billing_address', function(e){
		copyForms();
	})


	function populateForm(data){

		var frm = $("#orderForm");
		var i;

		for (i in data) {
			 if (frm.is('select')) //special form types
			 {
			 	$('option', frm).each(function() {
			 		if (this.value == value)
			 			this.selected = true;
			 			// this.select2().trigger('change');

			 		// this.parents().select2().trigger('change');
			 			// this.attr('selected', 'selected');

			 	});
			 } else{

			 	frm.find('[name="' + i + '"]').val(data[i]);
			 }
			}
		}


		// copy billing to shipping
		function copyForms() {

			$("input[name='shipping_first_name']").val($("input[name='billing_first_name']").val());
			$("input[name='shipping_last_name']").val($("input[name='billing_last_name']").val());
			$("input[name='shipping_address_one']").val($("input[name='billing_address_one']").val());		
			$("input[name='shipping_address_two']").val($("input[name='billing_address_two']").val());			
			$("input[name='shipping_city']").val($("input[name='billing_city']").val());	
			$("input[name='shipping_zip_code']").val($("input[name='billing_zip_code']").val());	
			$("input[name='shipping_phone']").val($("input[name='billing_phone']").val());	
			$("input[name='shipping_email']").val($("input[name='billing_email']").val());	
			$("input[name='shipping_vat']").val($("input[name='billing_vat']").val());	
			
			$("select[name='shipping_country']").val($("select[name='billing_country']").val()).trigger('change');	
			$("select[name='shipping_region']").val($("select[name='billing_region']").val()).trigger('change');	
		}

	})