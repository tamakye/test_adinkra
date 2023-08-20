$(function(){
	$.ajaxSetup({
		headers: {
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
		}
	});

	// $(document).on('click', '.navbar-toggler', function(){
	// 	$('#navbarSupportedContent').toggle();
	// })

	// $(document).on('click', '.search__input, .search__submit', function(){
	// 	$('.search-content').toggleClass('content-width');
	// 	$('.search__input').toggleClass('search-border');
	// })

	// $(document).on('change', '.search__input, .search__submit', function(){
	// 	$('.search-content').removeClass('content-width');
	// 	$('.search__input').removeClass('search-border');
	// })

	
	$(document).on('change', '.sizes', function(){
		$('.product-price').html($(this).find('option:selected').data('price'));
	})

	
	$(".select2").select2({
		// theme: 'bootstrap4',
		allowClear: true,
		placeholder: "",
	});
	
	$(".select2-multiple").select2({
		// theme: 'bootstrap4',
		placeholder: 'Choose options',
		allowClear: true,
	});

	$(".select2-tags").select2({
		// theme: 'bootstrap4',
		placeholder: 'Choose options',
		allowClear: true,
		tags: true
	});

	$(".select2-multiple-tags").select2({
		// theme: 'bootstrap4',
		placeholder: 'Choose options',
		allowClear: true,
		tags: true,
		multiple: true
	});

	 // datetime
	$('.datetime').datetimepicker({
		format:'d/m/Y H:i',
	});

	$('.date').datetimepicker({
		timepicker:false,
		format:'d/m/Y',
	});



	$('[data-toggle="tooltip"]').tooltip();


	$(document).on('input', '.numeric', function(event) {
		var inputValue = $(this).val();
		var filteredValue = inputValue.replace(/[^0-9.]/g, "");
		$(this).val(filteredValue);
	});
	

	$(document).on('change', '#country', function(){

		$.post('/country/fetch-regions', {'country': $(this).val()}, function(data){

			let options = [];
			options.push('<option value=""></option>');


			$.each(data, function(index, item){
				options.push('<option value="'+item.id+'">'+item.name+'</option>');
			})

			$('#region').empty().append(options);

		}, 'json');
	});


		// subscribe
	$(document).on('click', '.subscribe-btn', function(e){
		let email = $('.subscribe_imput').val();

		if (email == '') {
			toastr.error('Email can not be empty');
			return;
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


})