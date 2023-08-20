<?php

use App\Models\Category;

function getTaxValue($condition_name, $order_number){

	$calculatedValue = 0;
	$condition = Cart::session($order_number)->getCondition($condition_name);

	if (!empty($condition)) {
		
		
		$subTotal = Cart::session($order_number)->getSubTotal();

		$calculatedValue = $condition->getCalculatedValue($subTotal);

	}

	return $calculatedValue;
}


/**
 * Gets the children.
 *
 * @param      <type>  $category  The category
 *
 * @return     <type>  The children.
 */
function get_children($category){

	return Category::where('category_id', $category->id)->get();

}


function createTree($arrData, $level = 0)
{
	$level ++;
	foreach($arrData AS $obj)
	{
		echo '<option value='.$obj->id.'>'.str_repeat('-', $level).$obj->name.'</option>';
		if (get_children($obj) && is_array(get_children($obj)))
		{
			$this->createTree($obj->children, $level);
		}
	}
}


