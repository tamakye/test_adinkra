$(function(){
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $(".select2").select2({
        theme: 'bootstrap4',
        allowClear: true,
        placeholder: "Choose option",
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



    $('[data-toggle="tooltip"]').tooltip();

    $('table.display').DataTable();

    $(document).on('keyup keypress keydown', '.slug', function(){
      addHyphen(this)
  })

	 //add hyphen to url
    function addHyphen (element) {
     	// let ele = document.getElementById(element.id);
        // ele = element.value.split('-').join('');    // Remove dash (-) if mistakenly entered.
        // let finalVal = ele.match(/.{''}/g).join('-');

        let finalVal = element.value.replace(/\s+/g, '-');
        document.getElementById(element.id).value = finalVal;
    }


    // limit all values in input
    $('input').attr('maxlength', 250);

    $(document).on('change', 'input', function(){
    	if (this.value.length > 250) {
    		this.value = this.value.slice(0, 250);
    	}
    });


    // on change os make, populate model
    $(document).on('change', '#make', function(){
        let id = $(this).val();
        let options = [];
        options.push('<option value="" selected hidden disabled> Select model </option>');

        $.post('/dashboard/fetch-car-models', {id: id}, function(data){

            $.each(data, function(key, item){
                options.push('<option value=' + item.id + '>' + item.name + '</option>');
            });

            $("#model").empty().append(options).removeAttr('disabled');
        })
    })  

     // on change os model, populate model
    $(document).on('change', '#model', function(){
        let id = $(this).val();

        let options = [];
        options.push('<option value="" selected hidden disabled> Select model type </option>');

        $.post('/dashboard/fetch-car-model-types', {id: id}, function(data){
            $.each(data, function(key, item){
                options.push('<option value=' + item.id + '>' + item.name + '</option>');
            });

            $("#car_type").empty().append(options).removeAttr('disabled');
        })
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