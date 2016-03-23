<?php

namespace App\ViewModel;

use Illuminate\Database\Eloquent\Model;
use Log;

class ProductViewModel extends Model
{
	protected $fillable = array(
						 	'SrNo', 
						 	'TotalRecordCount', 
						 	'ProductID',
						 	'ProductName',
						 	'Description',
						 	'Price'
						   );
	
	protected function validate($data){	
		$validator = "";	
		$rules = array(
					'SrNo'     				=> 'sometimes|regex:/^[0-9.]*$/',
					'TotalRecordCount'     	=> 'sometimes|regex:/^[0-9.]*$/',
					'ProductID' 			=> 'sometimes|regex:/^[0-9.]*$/',
					'ProductName'  			=> 'required|regex:/^[A-Za-z0-9 ,.\'\-\(\)\/]+$/|min:1|max:250',
					'Description'  			=> 'required|regex:/^[A-Za-z0-9 ,.\'\-\(\)\/]+$/|min:1|max:250',
					'Price'  				=> 'required|regex:/^[0-9.]*$/'
				);	
		$messages = array(
					'SrNo.regex' 				=> 'Invalid SrNo.',
					'TotalRecordCount.regex'	=> 'Invalid TotalRecordCount.',
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
				);
				
		Log::info('[ProductViewModel/validate] validate function start');				
		Log::info('[ProductViewModel/validate] $data'.PHP_EOL. print_r($data, true));

		foreach ($data as $row) {
			
			$validator = \Validator::make($row, $rules, $messages);
			if($validator->fails()){
				Log::info('[ProductViewModel/validate/foreachLines] $validator '.$validator->messages());
				return $validator;				
			}

			/*
			for ($i=0; $i < sizeof(array_keys($row)); $i++) {				
				$ColumnName = array_keys($row)[$i];
				$this->{$ColumnName} = $row[$ColumnName];					
			}

			Log::info("SrNo = ".$this->SrNo);
			Log::info("TotalRecordCount = ".$this->TotalRecordCount);
			Log::info("ProductID = ".$this->ProductID);			
			Log::info("ProductName = ".$this->ProductName);
			Log::info("Description = ".$this->Description);
			Log::info("Price = ".$this->Price);
			*/
		}
		Log::info('[ProductViewModel/validate] loop end');		
		return $validator;
	}
}