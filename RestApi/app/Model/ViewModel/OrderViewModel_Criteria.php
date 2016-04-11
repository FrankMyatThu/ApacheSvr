<?php

namespace App\Model\ViewModel;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Log;

// To search data
class OrderViewModel_Criteria extends Model
{
	protected $fillable = array(		
						 	'SrNo',						 	
						 	'OrderId',
						 	'Description',
						 	'OrderDate',

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
					'SrNo'     						=> ['sometimes', Config::get('FormatStandardizer.SrNo') ],					
					'OrderId' 						=> ['sometimes', Config::get('FormatStandardizer.ID') ],					
					'Description'  					=> ['sometimes', Config::get('FormatStandardizer.Description') , 'min:1', 'max:250'],
					'OrderDate'						=> ['sometimes', 'date_format:"d/m/Y"' ],
					'OrderByClause'         		=> ['sometimes', Config::get('FormatStandardizer.OrderByClause') ],
					'OrderDetails.*.OrderDetailId'	=> ['sometimes', Config::get('FormatStandardizer.ID') ],
					/*'OrderDetails.*.OrderId'		=> ['sometimes', Config::get('FormatStandardizer.ID') ],
					'OrderDetails.*.ProductID'		=> ['required', Config::get('FormatStandardizer.ID') ],
					'OrderDetails.*.ProductName'	=> ['sometimes', Config::get('FormatStandardizer.Name') ],
					'OrderDetails.*.Quantity'		=> ['required', Config::get('FormatStandardizer.Numeric') ],
					'OrderDetails.*.Total'			=> ['required', Config::get('FormatStandardizer.Numeric') ],
					'OrderDetails.*.TotalGST'		=> ['required', Config::get('FormatStandardizer.Numeric') ],*/
				);	
		$messages = array(
					'SrNo.regex' 								=> 'Invalid SrNo.',					
					'OrderId.regex' 							=> 'Invalid OrderId.',					
					'Description.required' 						=> 'Description is required.',
					'Description.regex'							=> 'Invalid Description.',
					'Description.min'							=> 'Description\'s length should be between 1 and 250.',
					'Description.max'							=> 'Description\'s length should be between 1 and 250.',
					'OrderDate.required'						=> 'OrderDate is required.',
					'OrderDate.date_format'						=> 'Invalid OrderDate.',	
					'OrderByClause.regex'						=> 'Invalid OrderByClause.',
					'OrderDetails.*.OrderDetailId.regex'		=> 'Invalid OrderDetailId.',
					/*'OrderDetails.*.OrderId.regex'				=> 'Invalid Line OrderId.',
					'OrderDetails.*.ProductID.regex'			=> 'Invalid ProductID.',
					'OrderDetails.*.ProductName.regex'			=> 'Invalid ProductName.',
					'OrderDetails.*.Quantity.regex'				=> 'Invalid Quantity.',
					'OrderDetails.*.Total.regex'				=> 'Invalid Total.',
					'OrderDetails.*.TotalGST.regex'				=> 'Invalid TotalGST.'	*/				
				);
				
		Log::info('[OrderViewModel_Criteria/validate] validate function start');				
		//Log::info('[OrderViewModel_Criteria/validate] $data'.PHP_EOL. print_r($data, true));

		$validator = \Validator::make($data, $rules, $messages);				
		return $validator;
	}
}