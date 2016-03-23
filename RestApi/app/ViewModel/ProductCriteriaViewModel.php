<?php

namespace App\ViewModel;

use Illuminate\Database\Eloquent\Model;
use Log;

// To search data
class ProductCriteriaViewModel extends Model
{
    protected $fillable = array(
						 	'SrNo', 
						 	'TotalRecordCount', 
						 	'ProductID',
						 	'ProductName',
						 	'Description',
						 	'Price',
						 	'BatchIndex',
						 	'BatchIndex',
						 	'BatchIndex',
						 	'BatchIndex',
						 	'BatchIndex',
						 	'BatchIndex',

						   );
	
	protected function validate($data){	
		$validator = "";	
		$rules = array(
					'SrNo'     				=> 'sometimes|regex:/^[0-9.]*$/',
					'TotalRecordCount'     	=> 'sometimes|regex:/^[0-9.]*$/',
					'ProductID' 			=> 'sometimes|regex:/^[0-9.]*$/',
					'ProductName'  			=> 'sometimes|regex:/^[A-Za-z0-9 ,.\'\-\(\)\/]+$/|min:0|max:250',
					'Description'  			=> 'sometimes|regex:/^[A-Za-z0-9 ,.\'\-\(\)\/]+$/|min:0|max:250',
					'Price'  				=> 'sometimes|regex:/^[0-9.]*$/'
				);	
		$messages = array(
					'SrNo.regex' 				=> 'Invalid SrNo.',
					'TotalRecordCount.regex'	=> 'Invalid TotalRecordCount.',
					'ProductID.regex' 			=> 'Invalid ProductID.',					
					'ProductName.regex'			=> 'Invalid Product Name.',
					'ProductName.min'			=> 'Product Name\'s length should be between 1 and 250.',
					'ProductName.max'			=> 'Product Name\'s length should be between 1 and 250.',					
					'Description.regex'			=> 'Invalid Description.',
					'Description.min'			=> 'Description\'s length should be between 1 and 250.',
					'Description.max'			=> 'Description\'s length should be between 1 and 250.',					
					'Price.regex'   			=> 'Invalid Price',
				);
				
		Log::info('[ProductViewModel/validate] validate function start');				
		Log::info('[ProductViewModel/validate] $data'.PHP_EOL. print_r($data, true));

		foreach ($data as $row) {			
			$validator = \Validator::make($row, $rules, $messages);
			if($validator->fails()){				
				return $validator;				
			}
		}			
		return $validator;
	}
}
