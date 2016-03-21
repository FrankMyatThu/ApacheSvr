<?php

namespace App\ViewModel;

use Illuminate\Database\Eloquent\Model;
use Log;

class ProductViewModel extends Model
{
    public $SrNo;
	public $TotalRecordCount;
	public $ProductID;
	public $ProductName;
	public $Description;
	public $Price;
	
	protected function validate($data){
		$returnValue = true;		
		$rules = array(
					'SrNo'     				=> 'sometimes|regex:/^[0-9.]*$/',
					'TotalRecordCount'     	=> 'sometimes|regex:/^[0-9.]*$/',
					'ProductID' 			=> 'sometimes|regex:/^[0-9.]*$/',
					'ProductName'  			=> 'required|regex:/^[A-Za-z0-9 ,.\'-]+$/|min:1|max:250',
					'Description'  			=> 'required|regex:/^[A-Za-z0-9 ,.\'-]+$/|min:1|max:250',
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
		//Log::info('[ProductViewModel/validate] First line message. \r\nSecond line message.');
		log::info(gettype($data));
		Log::info('[ProductViewModel/validate] $data'.PHP_EOL.$data);				
		foreach (json_decode($data, true) as $row) {
			foreach($row as $value){
				Log::info('[ProductViewModel/validate/foreachLines] $value ' . $value);
			}
			if(\Validator::make($row, $rules, $messages) == false){
				$returnValue = false;
				break;
			}
		}
		Log::info('[ProductViewModel/validate] loop end');
		
		return $returnValue;
	}
}