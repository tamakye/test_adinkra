
$(function(){

	var rowIndex = $('.count_values').val(); 

	$(document).on('click', '#addBtn', function(){

		let tr = `<tr class="tableRow" id="${++rowIndex}">
		<td class="row-index"> <span>${rowIndex}</span></td>
		<td class="text-center">
		<div class="custom-control custom-radio">
		<input type="radio" id="ck_${rowIndex}" name="default" class="custom-control-input default" ${rowIndex  == 1 ? 'checked' : ''}>
		<label class="custom-control-label" for="ck_${rowIndex}"></label>
		</div>
		</td>
		<td><input type="text" name="title[]" class="form-control title"></td>
		<td><input type="text" name="slug[]" class="form-control slug" id="slug_${rowIndex}"></td>
		<td><input type="color" name="colour[]" class="form-control" value="#1ebdc2"></td>
		<td>
		<div class="preview m-auto"  style="width: 50px !important">
		<img class="img-thumbnail cursor image_preview" src="/images/system/image_holder.png" alt="Thumbnail image" >
		</div>
		<div class="custom-file  mt-4" style="display: none;">
		<input type="file" name="thumbnail[]" class="custom-file-input thumbnail" accept=".png, .jpg, .jpeg" disabled>
		</div>
		</td>
		<td class="text-center">
		<a href="javascript:void(0)" class="text-danger removeRow"><i class="fas fa-trash"></i></a>
		</td>
		</tr>
		`;

		$('#tbody').append(tr);

		$('#tbody .tableRow:last input').attr('required', 'required');
	})

	// $('#attributeTable').on('keyup keypress keydown', ".slug", function(){
	// 	addHyphen(this)
	// })

	// //add hyphen to url
	// function addHyphen (element) {
	// 	// let ele = element.value.split('-').join('');
	// 	// ele = element.value.split('/').join('');
	// 	ele_value = element.value.replace(/\\|\//g,'');
	// 	let finalVal = ele_value.replace(/\s+/g, '-');
	// 	document.getElementById(element.id).value = finalVal.toLowerCase();
	// }

	// $(document).on('keyup keypress keydown', ".a_title", function(){
	// 	console.log('sfdasdfs');
	// })

	$(document).on('click', ".removeRow", function(){
		var child = $(this).closest('tr').nextAll();

		child.each(function(){
			var id = $(this).attr('id');

			var idx = $(this).children('.row-index').children('span'); 
			var check = $(this).find('.default');
			var label = $(this).find('.custom-control-label');

			var dig = parseInt(id); 

			idx.html(`${dig - 1}`); 
			check.attr('id', `ck_${dig - 1}`);
			label.attr('for', `ck_${dig - 1}`);

			$(this).attr('id', `${dig - 1}`);
		})

		$(this).closest('.tableRow').remove();
		rowIndex--;
	})


	$(document).on('click', ".image_preview", function(){
		$(this).closest('.tableRow').find('.thumbnail').removeAttr('disabled').trigger('click');
	})

		// select and preview founder
	$(document).on('change', ".thumbnail", function(){
		let tableRow = $(this).closest('.tableRow');

		if (checkFile($(this).val())) {

			let reader = new FileReader();
			reader.onload = (e) => { 
				tableRow.find('.image_preview').show().attr('src', e.target.result); 
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


	$(document).on('click', ".save_btn", function(e){

		$('#save_status').val($(this).data('status'));
	})

	$(document).on('click', ".default", function(e){
		$('.default').prop('checked', false).val('');
		$(this).prop('checked', true).val($(this).closest('tr').find('.title').val());
	})

})