$(function(){

	$.ajaxSetup({
		headers : {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	})

	 // show countries
	 $(document).on('click', '.view_coutries', function(e){
	 	e.preventDefault();
	 	let id = $(this).data('id');
	 	$.post('/dashboard/fetch-shipping-countries', {id: id}, function(data){
	 		$(".modal-body-content").empty().append(data);
	 		$("#shippingModal").modal('show');
	 	})
	 })  

	})