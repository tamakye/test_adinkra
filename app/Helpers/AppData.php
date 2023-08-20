<?php

use App\Models\Attributevalue;
use App\Models\Category;

function title(){
	return [
		'Mr.',
		'Mrs.',
		'Justice',
		'Dr.',
		'Miss.',
		'Madam.',
		'Sir',
	];
}

function status(){

	return [
		'Draft',
		'Published',
		'Pending',
		'Disabled',
	];
}


function get_categories($id){

	return $categories = Category::where('collection_id', $id)->orderBy('name', 'asc')->get();

}

function get_atttibutevalue($id)
{
	return Attributevalue::find($id);
}


function get_product__price($product)
{
	return default_attribute_price($product['attributes'], count($product['attributes']));
}


function get_product_attribute_price($product)
{
	return default_attribute_price($product->attributes, count($product->attributes));
}

function default_attribute_price($attributes, $total_attibutes){
	$att_value = null;
	$loop = 0;

	foreach ($attributes as $key => $attribute) {
		$loop += $key + 1;

		$value =  get_atttibutevalue($attribute->pivot->attributevalue_id);

		if($value->default == 1){
			$att_value = $attribute->pivot->attribute_price;
			break;
		}else{

			$value = $loop == $total_attibutes ?  get_atttibutevalue($attribute->pivot->attributevalue_id) : 0 ;
			$att_value = $attribute->pivot->attribute_price;
		}
	}

	return $att_value;
}