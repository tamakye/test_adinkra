$(function(){

	$.ajaxSetup({
		headers: {
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
		}
	});

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



	// select and preview inspiration image
	$(document).on('change', "#inspiration", function(){

		if (checkFile($(this).val())) {

			let reader = new FileReader();
			reader.onload = (e) => { 
				$('#imageinspiration_preview').show().attr('src', e.target.result).css({'width':'300px'}); 
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


	

	// Validate input counts

	$(document).on('keyup keydown', "#product_name", function(){
		let max = 120;

		if (this.value.length > max) {

			this.value = this.value.slice(0, 120);
			$('.product_name_count').html(0);

		}else{
			let count = max - this.value.length;
			$('.product_name_count').html(count);
		}
	})

	$(document).on('keyup keydown', "#sku", function(){
		let max = 30;

		if (this.value.length > max) {

			this.value = this.value.slice(0, 30);
			$('.sku_count').html(0);

		}else{
			let count = max - this.value.length;
			$('.sku_count').html(count);
		}
	})

	$(document).on('keyup keydown', "#meta_title", function(){
		let max = 120;

		if (this.value.length > max) {

			this.value = this.value.slice(0, 120);
			$('.meta_title_count').html(0);

		}else{
			let count = max - this.value.length;
			$('.meta_title_count').html(count);
		}
	})

	$(document).on('keyup keydown', "#meta_description", function(){

		let max = 120;

		if (this.value.length > max) {

			this.value = this.value.slice(0, 150);
			$('.descriptions_count').html(0);

		}else{
			let count = max - this.value.length;
			$('.descriptions_count').html(count);
		}
	})

	$(document).on('keyup keydown', "#meta_keywords", function(){

		let max = 120;

		if (this.value.length > max) {

			this.value = this.value.slice(0, 150);
			$('.meta_keywords_count').html(0);

		}else{
			let count = max - this.value.length;
			$('.meta_keywords_count').html(count);
		}
	})

	// move-product-to-bin
	$(document).on('click', ".move-product-to-bin", function(){
		let slug = $(this).data('slug');

		$.post('/dashboard/products/move-to-bin', {slug: slug}, function(data){
			if (data.success) {
				toastr.success(data.success);
				$('#productsTable').load(location.href + ' #productsTable');
			}else{
				toastr.error('An error occured');
			}
		})
	})



	if ($('.input-field').length > 0) {

		$('.input-images').imageUploader({
			extensions: ['.jpg', '.jpeg', '.png'],
			maxFiles: 2
		});
		$('.upload-text').html('<i class="fas fa-upload"></i> <span>Drag &amp; Drop files here or click to browse</span>').addClass('text-muted');
	}


	// SEO
	$(document).on('click', '#edit-seo', function(){
		$('#seo').toggle();
	})
	$(document).on('keyup keydown', '#meta_title', function(){
		$('.seo-title').html($(this).val());
	})
	$(document).on('keyup keydown', '#meta_description', function(){
		$('.seo-description-text').html($(this).val());
	})


	// check a single payment
	$(document).on('click', '.single_check', function(){

		if ($(this).is(':checked')) {
			$('#bulkAction').removeAttr('disabled');
			$('#checkAll').prop('checked', true);

		}else if(checkedRequest()){
			$('#bulkAction').removeAttr('disabled');
			$('#checkAll').prop('checked', true);
		}else{
			$('#bulkAction').attr('disabled', 'disabled');
			$('#checkAll').prop('checked', false);
		}
	})

	// check all
	$(document).on('click', '#checkAll', function(){
		if ($(this).is(':checked')) {
			$('#bulkAction').removeAttr('disabled');
			$('.single_check').prop('checked', true);
			
		}else{
			$('#bulkAction').attr('disabled', 'disabled');
			$('.single_check').prop('checked', false);
			$(this).prop('checked', false);
		}
	})

	// bulk actions
	$(document).on('click', '.bulkAction', function(){

		let status = $(this).data('status');
		$('#status').val(status);
		$('.show-mustang').hide();
		let action;
		if (status == 'draft') {
			action = "move the selected products to draft?";
		}else if(status == 'delete'){
			action = "move the selected products to bin?";
		}else if(status == 'publish'){
			action = "publish the selected products?";
		}else if(status == 'protect'){
			action = "password protect the selected products?";
			$('.show-mustang').show();
		}else if(status == 'unprotect'){
			action = "protect the selected products?";
		}

		$('.action_to_perfom').html(action);
		pushCheckedItemsToArray();
		$('#bulkActionModal').modal('show');
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

	// push ids to array
	function pushCheckedItemsToArray(){
		let ids = [];

		$(".single_check:checked").each(function () {
			ids.push($(this).data('id'));
		});

		let single  = $(this).data('id') ?? '';

		if (single !=  '') {
			ids.push(single);
		}

		ids = JSON.stringify( ids );

		$('#products').val(ids);
	}



	let attribute_total = $('.attribute_total').val();



	if ($('.product_attributes').length > attribute_total) {
		$('.add_fields').hide();
	}



    // add attribute fields
	$(document).on('click', ".add_fields", function(){

		let button = $(this);

		$.post('/dashboard/products/fetch-attributes', function(data) {

			$('#attributes').append(data);
			$('.attributes-row').last().find('.select2').select2(null).trigger('change');

		});

		if ($('.attributes-row').length + 1 >= $('.attribute_total').val()) {
			$('.add_fields').hide();
		}

	})

     // remove attribute fields
	$(document).on('click', ".remove_fields", function(){
		$(this).parents('.attributes-row').remove();

		if ($('.attributes-row').length < $('.attribute_total').val()) {
			$('.add_fields').show();
		}
	})

    // attributes
	$(document).on('change', ".product_attributes", function(){
		let attribute = $(this);

		$.post('/dashboard/products/fetch-attributes/values', {id:attribute.val()}, function(data) {
			let options = ['<option value="" selected disabled></option>'];
			$.each(data, function(index, item){
				let option = '<option value="'+item.id+'" >'+item.title+'</option>';
				options.push(option);
			})

			attribute.parents('.attributes-row').find('.attributevalues').html('').append(options);
		})
	})


	$(document).on('change', "#product_collection", function(){
		let collection = $(this);

		$.post('/dashboard/products/fetch-categories', {id:collection.val()}, function(data) {
			// let options = ['<option value="" selected disabled></option>'];
			let options = [];
			$.each(data, function(index, item){
				let option = '<option value="'+item.id+'" >'+item.name+'</option>';
				options.push(option);
			})

			$('#product_category').html('').append(options);
		})
	})

})