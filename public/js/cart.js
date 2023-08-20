
$(function(){

	$.ajaxSetup({
		headers: {
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
		}
	});

	// add to cart
	$(document).on('click', '.add-to-cart', function(e){

		let button =  $(this);
		let product = button.data('product');
		let attributevalue = $('.sizes').val();
		let price = $('.sizes option:selected').data('price');

		button.html('<i class="fas fa-spin fa-spinner"></i> Adding...').attr('disabled', 'disabled');

		$.post('/cart/add', {product: product, attributevalue:attributevalue, price:price}, function(data){

			if (data.success) {
				refreshItems();
				toastr.success(data.success);
				// button.html('Add to cart').removeAttr('disabled');
			}else{
				toastr.error(data.error);
				button.html('Add to cart').removeAttr('disabled');
			}
		})

	})

		// update basket
	$(document).on('change', '.update_basket', function(e){

		$(this).siblings('.basket_quantity').val($(this).val());
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

		let info = $(this).siblings('.update-cart-info');
		info.html('<i class="fas fa-spin fa-spinner"></i> Updating cart...')

		$.ajax({
			url: '/update-cart',
			data: formData,
			processData: false,
			contentType: false,
			type: 'POST',
			success: function(data){
				if (data.success) {
					refreshItems();
					toastr.success(data.success);
					info.html('')

				}else{
					info.html('')
					toastr.error(data.error);
				}
			}
		});

	})	



		// remove item from basket
	$(document).on('click', '.remove_item', function(e){
		let item_id = $(this).data('item');

		$.post('/remove-from-cart', {item_id: item_id}, function(data){

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
	

		// refresh list
	function refreshItems(){
		$('.refresh-cart').load(location.href + ' .refresh-cart');
		$('.refresh-item').load(location.href + ' .refresh-item');
		$('.refresh-cart-items').load(location.href + ' .refresh-cart-items');
		$('.refresh-cart-count').load(location.href + ' .refresh-cart-count');

		$('.select2').select2()
		// if ($('.showAddedToBasket')) {
		// 	$('.showAddedToBasket').show();
		// }
	}

	function refreshWishlist(){
		$('.refresh-wishlist').load(location.href + ' .refresh-wishlist');
	}	



// add to cart
	$(document).on('click', '.add-to-wish-list', function(e){

		let product = $(this).data('product');

		$.post('/product/add-to-wish-list', {product: product}, function(data){

			if (data.success) {
				refreshWishlist();
				toastr.success(data.success);

			}else{
				toastr.error(data.error);
			}
		})

	})


	$('.checkout-btn').attr('disabled', 'disabled');

	$(document).on('click', '.payment_method',  function() {

		$(this).children().find('.cart-loader').show();
		$('.checkout-btn').removeAttr('disabled');
		$('.payment_type').prop('checked', false).removeAttr('checked');;
		$(this).parents('.checkbox-item').find('.payment_type').prop('checked', true).attr('checked', 'checked');
	// $('.payment_method .card').addClass('bg-gray');
		$('.payment_method .card').removeClass('bg-gray');
		$(this).children('.card').addClass('bg-gray');

		setTimeout(function(){
			$('.cart-loader').hide();
		}, 500)
	})




	$(document).on('click', '#choose_address', function(){

		let customer = $(this).val();

		if ($(this).is(':checked')) {
			$('#address_slug').removeAttr('disabled');
			let status = 'user';
			$.post('/load-customer-address', {customer: customer, status: status, address_type: 'billing'}, function(data){

				populateForm(data);
			})
			// $.post('/load-customer-address', {customer: customer, status: status, address_type: 'shipping'}, function(data){
			// 	populateForm(data);
			// })
		}else{
			$("#checkoutForm")[0].reset();
			$(".form-control").removeClass('in-active');
			$('#address_slug').attr('disabled', 'disabled');
		}
	})



	function populateForm(data){

		var frm = $("#checkoutForm");
		var i;

		for (i in data) {
             if (frm.is('select')) //special form types
             {
             	$('option', frm).each(function(index, value) {

             		if (this.value == value)
             			this.selected = true;
                    // this.selected.trigger('change');

             	})

             } else{

             	frm.find('[name="' + i + '"]').val(data[i]).addClass('in-active');
             }
           }

           $('.select2').trigger('change');
           $('#new_address').trigger('click');
      // $('.shipping_items').attr('required', 'required');
        // $('#billing_country').trigger('change');
        // $('#shipping_country').trigger('change');
         }



         $(document).on('click', '#new_address', function(){

         	if($(this).is(':checked')){
         		$('.shipping_items').attr('required', 'required');
         		$('.shipping-box').show();
         	}else{
         		$('.shipping_items').removeAttr('required');
         		$('.shipping-box').hide();
         	}

         })


         $(document).on('change', '#billing_country', function(){

         	$.post('/country/fetch-regions', {'country': $(this).val()}, function(data){

         		let options = [];
         		options.push('<option value=""></option>');


         		$.each(data, function(index, item){
         			options.push('<option value="'+item.id+'">'+item.name+'</option>');
         		})

         		$('#billing_region').empty().append(options);

         	}, 'json');

		// process shipping cost on change of billing
         	proccess_shipping();

         });


         $(document).on('change', '#shipping_country', function(){

         	$.post('/country/fetch-regions', {'country': $(this).val()}, function(data){

         		let options = [];
         		options.push('<option value=""></option>');


         		$.each(data, function(index, item){
         			options.push('<option value="'+item.id+'">'+item.name+'</option>');
         		})

         		$('#shipping_region').empty().append(options);

         	}, 'json');


     	// process shipping cost on change of billing
         	proccess_shipping();
         });



	//Calculate shpping cost
     // $(document).on('click', '.calculat_shipping', function(e){
     // 	let formData = new FormData();
     // 	formData.append('shipping_country', $('#shipping_country').val());
     // 	formData.append('shipping_region', $('#shipping_region').val());
     // 	formData.append('shipping_city', $('#shipping_city').val());
     // 	formData.append('shipping_zip_code', $('#shipping_zip_code').val());

     // 	let button = $(this);
     // 	button.html('<i class="fas fa-spin fa-spinner"></i> Updating...')

     // 	process_shipping_cost(formData, button);

     // })

	// on click of shipping 
     // $(document).on('click', '#showNewShippingForm', function(e){

     // 	let formData = new FormData();

     // 	if ($(this).is(':checked')) {
     // 		formData.append('shipping_country', $('#shipping_country').val());
     // 		formData.append('shipping_region', $('#shipping_region').val());
     // 		formData.append('shipping_city', $('#shipping_region').val());
     // 		formData.append('shipping_zip_code', $('#shipping_zip_code').val());
     // 	}else{
     // 		formData.append('shipping_country', $('#billing_country').val());
     // 		formData.append('shipping_region', $('#billing_region').val());
     // 		formData.append('shipping_city', $('#billing_city').val());
     // 		formData.append('shipping_zip_code', $('#billing_zip_code').val());
     // 	}

     // 	process_shipping_cost(formData);
     // })

         function proccess_shipping(){

         	let formData = new FormData();

         	if ($('#new_address').is(':checked')) {
         		formData.append('shipping_country', $('#shipping_country option:selected').val());
         		formData.append('shipping_region', $('#shipping_region').val());
         		formData.append('shipping_city', $('#shipping_region').val());
         		formData.append('shipping_zip_code', $('#shipping_zip_code').val());
         	}else{
         		formData.append('shipping_country', $('#billing_country').val());
         		formData.append('shipping_region', $('#billing_region').val());
         		formData.append('shipping_city', $('#billing_city').val());
         		formData.append('shipping_zip_code', $('#billing_zip_code').val());
         	}

         	process_shipping_cost(formData);
         }


	// send shipping details to server
         function process_shipping_cost(formData, button = ''){

         	let info = $('.update-shipping-cost');
         	info.html('<i class="fas fa-spin fa-spinner"></i> Applying shipping cost...')

         	$.ajax({
         		url: '/calculate-shipping-cost',
         		data: formData,
         		processData: false,
         		contentType: false,
         		type: 'POST',
         		success: function(data){

         			if (data.success) {
         				// toastr.success(data.success);
         				info.html('');
         				refreshItems();
     				// $('#shipping_country').select2();

         			}else{
     				// $('#shipping_country').select2();
         				toastr.error(data.error);
         				info.html('');
         			}
         		}
         	});



         }


       })	






// var checkoutTotalCard = $('.checkoutTotalCard').offset();

// // console.log(checkoutTotalCard);
// var $window = $(window);
// // console.log($window);

// $window.scroll(function() {
// 	if ( $window.scrollTop() >= checkoutTotalCard.top) {
// 		$(".checkoutTotalCard").addClass("sticky-top");
// 	}else{
// 		$(".checkoutTotalCard").removeClass("sticky-top");
// 	}
// });