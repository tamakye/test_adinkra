// AOS.init();

$(function(){

	$.ajaxSetup({
		headers: {
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
		}
	});

	// homepage
	$(document).on('click', '#homePage form .checkbox label', function (e) {
		$(this).prev('input').attr('checked', 'checked');

		let sibling = $(this).siblings('input')[1];

		if($(sibling).attr('id') != $(this).prev('input').attr('id')) {
			$(sibling).removeAttr('checked');
		} else {
			$(this).next('input').removeAttr('checked');
		}
	});


	// select 2
	if ($('.select2').length > 0) {
		$('.select2').select2();
	}

	// shopt item
	$(document).on('click', '.shop-item, .shop_item_on_home', function(){
		let slug = $(this).data('slug')

		$("#loadingoverlay").fadeIn();
		
		$.post('/shop-by-carmake', {slug: slug}, function(data){
			$('.shop-modal-content').html(data);
			$('.car_model').select2();
			$('.car_type').select2();
			setTimeout(function(){
				$("#loadingoverlay").fadeOut();
				$('#shopItemModal').modal('show');
			}, 1000);
		})
	})	


	 // on change os model, populate model
	 $(document).on('change', '#model', function(){
	 	let slug = $(this).val();
	 	let options = [];
	 	options.push('<option value="" selected hidden disabled> Select model type </option>');

	 	$.post('/fetch-car-model-types', {slug: slug}, function(data){
	 		$.each(data, function(key, item){
	 			options.push('<option value=' + item.slug + '>' + item.name + '</option>');
	 		});

	 		$("#car_type").empty().append(options);
	 	})
	 })  


	// submit button
	$(document).on('click', '.btn-add-to-basket', function(e){
		let product = $(this).data('product');

		$.post('/add-to-basket', {product: product}, function(data){

			if (data.success) {
				refreshItems();
				toastr.success(data.success);
				
			}else{
				toastr.error(data.error);
			}
		})

	})	

	// enable of disable update button on change of quantity
	$(document).on('change', '.basket_quantity', function(e){
		
		if ($(this).val() == '' || $(this).val() == 0) {
			$('.update_basket').attr('disabled', 'disabled');
			toastr.error('Quantity can not be empty or zero!')
		}else{
			$('.update_basket').removeAttr('disabled');
		}
	})

	// update basket
	$(document).on('click', '.update_basket', function(e){
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

		let button = $(this);
		button.html('<i class="fas fa-spin fa-spinner"></i> Updating basket')

		$.ajax({
			url: '/update-basket',
			data: formData,
			processData: false,
			contentType: false,
			type: 'POST',
			success: function(data){
				if (data.success) {
					refreshItems();
					toastr.success(data.success);
					button.html('Update basket')

				}else{
					button.html('Update basket')
					toastr.error(data.error);
				}
			}
		});

	})	

	// remove item from basket
	$(document).on('click', '.remove_item', function(e){
		let item_id = $(this).data('item');

		$.post('/remove-from-basket', {item_id: item_id}, function(data){

			if (data.success) {
				refreshItems();
				toastr.success(data.success);
				
			}else{
				toastr.error(data.error);
			}
		})

	})	

	// appply coupon
	$(document).on('click', '.apply_coupon', function(e){
		let coupon = $('#coupon').val();

		if (coupon == '') {
			toastr.error('Coupon can not be empty');
			return false;
		}

		$.post('/apply-coupon', {coupon: coupon}, function(data){

			if (data.info) {
				refreshItems();
				toastr.info(data.info);
				
			}else{
				toastr.error(data.error);
			}
		})

	})	
	


	// show shipping
	$(document).on('click', '.show-shipping',function (e) {
		e.preventDefault();
		$('.calculate-shipping').toggle();
	});

	// Populate region or county
	$(document).on('change', '#billing_country', function(e){

		let country = $(this).val();
		$.post('/fetch-regions', {country: country}, function(data){

			let options = ['<option selected hidden disabled value="">Choose region</option>'];
			if (data.length > 0) {
				$.each(data, function(key, item){
					let option = '<option value="'+item.region_name+'">'+item.region_name+'</option>';
					options.push(option);
				})

				$('.billing_region_input').attr('disabled', 'disabled').hide();
				$('#billing_county').html('').append(options);
				$('.billing_region_select').removeAttr('disabled').show().select2();

			}else{
				$('.billing_region_select').select2().attr('disabled', 'disabled').select2('destroy').hide();
				$('.billing_region_input').val('').removeAttr('disabled').attr('placeholder', 'Enter county').show();
			}
		})

	})

	$(document).on('change', '#shipping_country', function(e){

		let country = $(this).val();
		$.post('/fetch-regions', {country: country}, function(data){

			let options = ['<option selected hidden disabled value="">Choose region</option>'];
			if (data.length > 0) {
				$.each(data, function(key, item){
					let option = '<option value="'+item.region_name+'">'+item.region_name+'</option>';
					options.push(option);
				})

				$('.shipping_region_input').attr('disabled', 'disabled').hide();
				$('#shipping_county').html('').append(options);
				$('.shipping_region_select').removeAttr('disabled').show().select2();

			}else{
				$('.shipping_region_select').select2().attr('disabled', 'disabled').select2('destroy').hide();
				$('.shipping_region_input').val('').removeAttr('disabled').attr('placeholder', 'Enter county').show();
			}
		})

	})

	// $(document).on('change', '#shipping_country, #billing_country', function(e){

	// 	let country = $(this).val();
	// 	$.post('/fetch-regions', {country: country}, function(data){

	// 		let options = ['<option selected hidden disabled value="">Choose region</option>'];
	// 		if (data.length > 0) {
	// 			$.each(data, function(key, item){
	// 				let option = '<option value="'+item.region_name+'">'+item.region_name+'</option>';
	// 				options.push(option);
	// 			})

	// 			$('.region_input').attr('disabled', 'disabled').hide();
	// 			$('#shipping_county, #billing_county').html('').append(options);
	// 			$('.region_select').removeAttr('disabled').show().select2();

	// 		}else{
	// 			$('.region_select').select2().attr('disabled', 'disabled').select2('destroy').hide();
	// 			$('.region_input').val('').removeAttr('disabled').attr('placeholder', 'Enter county').show();
	// 		}
	// 	})

	// })


	//Calculate shpping cost
	$(document).on('click', '.calculat_shipping', function(e){
		let formData = new FormData();
		formData.append('shipping_country', $('#shipping_country').val());
		formData.append('shipping_county', $('#shipping_county').val());
		formData.append('shipping_city', $('#shipping_city').val());
		formData.append('shipping_postcode', $('#shipping_postcode').val());

		let button = $(this);
		button.html('<i class="fas fa-spin fa-spinner"></i> Updating...')

		process_shipping_cost(formData, button);

	})

	// on click of shipping 
	$(document).on('click', '#showNewShippingForm', function(e){

		let formData = new FormData();

		if ($(this).is(':checked')) {
			formData.append('shipping_country', $('#shipping_country').val());
			formData.append('shipping_county', $('#shipping_county').val());
			formData.append('shipping_city', $('#shipping_county').val());
			formData.append('shipping_postcode', $('#shipping_postcode').val());
		}else{
			formData.append('shipping_country', $('#billing_country').val());
			formData.append('shipping_county', $('#billing_county').val());
			formData.append('shipping_city', $('#billing_city').val());
			formData.append('shipping_postcode', $('#billing_postcode').val());
		}

		process_shipping_cost(formData);
	})

	// on change of countries
	$(document).on('change', '.country_select', function(e){

		let formData = new FormData();

		if ($('#showNewShippingForm').is(':checked')) {
			formData.append('shipping_country', $('#shipping_country').val());
			formData.append('shipping_county', $('#shipping_county').val());
			formData.append('shipping_city', $('#shipping_county').val());
			formData.append('shipping_postcode', $('#shipping_postcode').val());
		}else{
			formData.append('shipping_country', $('#billing_country').val());
			formData.append('shipping_county', $('#billing_county').val());
			formData.append('shipping_city', $('#billing_city').val());
			formData.append('shipping_postcode', $('#billing_postcode').val());
		}

		process_shipping_cost(formData);
	})


	// send shipping details to server
	function process_shipping_cost(formData, button = ''){
		$.ajax({
			url: '/calculate-shipping-cost',
			data: formData,
			processData: false,
			contentType: false,
			type: 'POST',
			success: function(data){

				if (data.success) {
					refreshItems();
					toastr.success(data.success);
					$('#shipping_country').select2();

				}else{
					button.html('Update')
					$('#shipping_country').select2();
					toastr.error(data.error);
				}
			}
		});
	}



	// refresh list
	function refreshItems(){
		$('.refresh-cart').load(location.href + ' .refresh-cart');
		$('.refresh-item').load(location.href + ' .refresh-item');

		if ($('.showAddedToBasket')) {
			$('.showAddedToBasket').show();
		}
	}


	// subscribe
	$(document).on('click', '.subscribe', function(e){
		let email = $('.subscribe_imput').val();

		if (email == '') {
			toastr.error('Email can not be empty');

		}else{

			$.post('/subscribe', {email: email}, function(data){

				if (data.success) {

					toastr.success(data.success);
					$('.subscribe_imput').val('');

				}else{
					toastr.error(data.error);
				}
			})
		}
		

	})

	$(document).on('click', '.submit-news-letter', function(e){

		if ($('.email').val() == '' || $('.name').val() == '' || $('.company_name').val() == '' || $('.phone').val() == '') {
			toastr.error('All fields are required');

		}else{
			let btn = $(this);
			btn.html('<i class="fas fa-spinner fa-spin "></i> DOWNLOADING').attr('disabled', 'disabled');
			$.post('/news-letter', $('.newsletterForm').serialize(), function(data){

				if (data.success) {

					toastr.success(data.success);
					$('.newsletterForm')[0].reset();
					btn.html('DOWNLOAD NOW').removeAttr('disabled');
					$('#downloadModal').modal('show');
				}else{
					btn.html('DOWNLOAD NOW').removeAttr('disabled');
					toastr.error(data.error);
				}
			})
		}
		

	})


	// user profile
	$(document).on('click', '.add-attachment', function(){
		$('#attachment').trigger('click');
	})

	
	$(document).on('change', '#attachment', function(){
		if (checkFile($(this).val())) {
			let filename = $(this).val().replace(/.*(\/|\\)/, '');
			$('.add-attachment').hide();
			$('.show-filename').html(filename);
			$('.show-box').addClass('inherit');
		}else{
			$(this).val('');
			toastr.error('File is not supported. Check the file type');
		}
	})

	$(document).on('click', '.close-file', function(){
		$('.show-filename').html('');
		$('.show-box').removeClass('inherit');

		$('.add-attachment').show();
	})

	$('.tickets-form').on('submit', function(){
		$('.save-ticket').attr('disabled', 'disabled');
	})

	// check image upload
	function checkFile(val){
		let valid;
		switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
			case 'jpeg': case 'jpg': case 'png': case 'doc':  case 'docx': case 'pdf': case 'zip':
			valid =  true;
			break;

			default:
			valid = false;
			break;
		}

		return valid;
	}
})