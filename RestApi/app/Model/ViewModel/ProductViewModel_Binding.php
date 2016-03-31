<?php

namespace App\Model\ViewModel;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Log;

// To bind data
class ProductViewModel_Binding extends Model
{
	protected $fillable = array(		
						 	'SrNo', 						 	
						 	'ProductID',
						 	'ProductName',
						 	'Description',
						 	'Price',
						 	'ProductImage'
						   );
	
	protected function validate($data){	
		$validator = "";	
		$rules = array(
					'SrNo'     				=> ['sometimes', Config::get('FormatStandardizer.SrNo') ],					
					'ProductID' 			=> ['sometimes', Config::get('FormatStandardizer.ProductID') ],
					'ProductName'  			=> ['required', Config::get('FormatStandardizer.ProductName') , 'min:1', 'max:250'],					
					'Description'  			=> ['required', Config::get('FormatStandardizer.ProductDescription') , 'min:1', 'max:250'],
					'Price'  				=> ['required', Config::get('FormatStandardizer.Price') ],
					//'ProductImage'			=> ['sometimes', Config::get('FormatStandardizer.ImagePath') ]
				);	
		$messages = array(
					'SrNo.regex' 				=> 'Invalid SrNo.',					
					'ProductID.regex' 			=> 'Invalid ProductID.',
					'ProductName.required' 		=> 'Product Name is required.',
					'ProductName.regex'			=> 'Invalid Product Name.',
					'ProductName.min'			=> 'Product Name\'s length should be between 1 and 250.',
					'ProductName.max'			=> 'Product Name\'s length should be between 1 and 250.',
					'Description.required' 		=> 'Description is required.',
					'Description.regex'			=> 'Invalid Description.',
					'Description.min'			=> 'Description\'s length should be between 1 and 250.',
					'Description.max'			=> 'Description\'s length should be between 1 and 250.',
					'Price.required'			=> 'Price is required',
					'Price.regex'   			=> 'Invalid Price',
					//'ProductImage.regex'		=> 'Invalid ProductImage',
				);
				
		Log::info('[ProductViewModel_Binding/validate] validate function start');				
		//Log::info('[ProductViewModel_Binding/validate] $data'.PHP_EOL. print_r($data, true));

		$validator = \Validator::make($data, $rules, $messages);				
		return $validator;
	}
}