<?php
namespace App\Traits;

use App\Models\Distributor;

trait DistributorTrait{

/**
* validate Email
*
* @return     <type>  ( description_of_the_return_value )
*/
public function emailExist(){
	return Distributor::where('slug', '!=', request()->slug)->where('email', request()->email)->first();
}


}