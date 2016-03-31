<?php

namespace App\Model\ViewModel;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Log;


// To search data
class ProductViewModel_Criteria extends Model
{
    protected $fillable = array(
							 	'SrNo', 							 	
							 	'ProductID',
							 	'ProductName',
							 	'Description',
							 	'Price',
							 	
							 	// Pager
							 	'BatchIndex',
							 	'PagerShowIndexOneUpToX',
							 	'RecordPerPage',
							 	'RecordPerBatch',
							 	'OrderByClause'
						   	);
	
	protected function validate($data){	
		$validator = "";
		$rules = array(
					'SrNo'     				=> ['sometimes', Config::get('FormatStandardizer.SrNo') ],					
					'ProductID' 			=> ['sometimes', Config::get('FormatStandardizer.ProductID') ],
					'ProductName'  			=> ['sometimes', Config::get('FormatStandardizer.ProductName') , 'min:0', 'max:250'],
					'Description'  			=> ['sometimes', Config::get('FormatStandardizer.ProductDescription') , 'min:0', 'max:250'],
					'Price'  				=> ['sometimes', Config::get('FormatStandardizer.Price') ],
					'OrderByClause'         => ['sometimes', Config::get('FormatStandardizer.OrderByClause') ]
				);	
		$messages = array(
					'SrNo.regex' 				=> 'Invalid SrNo.',					
					'ProductID.regex' 			=> 'Invalid ProductID.',					
					'ProductName.regex'			=> 'Invalid Product Name.',
					'ProductName.min'			=> 'Product Name\'s length should be between 1 and 250.',
					'ProductName.max'			=> 'Product Name\'s length should be between 1 and 250.',					
					'Description.regex'			=> 'Invalid Description.',
					'Description.min'			=> 'Description\'s length should be between 1 and 250.',
					'Description.max'			=> 'Description\'s length should be between 1 and 250.',					
					'Price.regex'   			=> 'Invalid Price.',
					'OrderByClause.regex'		=> 'Invalid OrderByClause.'
				);
				
		Log::info('[ProductViewModel_Criteria/validate] validate function start');				
		//Log::info('[ProductViewModel_Criteria/validate] $data'.PHP_EOL. print_r($data, true));

		$validator = \Validator::make($data, $rules, $messages);
		return $validator;
	}
}
