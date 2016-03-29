<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\ProductModel;
use App\ViewModel\ProductBindingViewModel;
use App\ViewModel\ProductCriteriaViewModel;
use Log;

class ProductController extends Controller
{
	// Create	
    public function CreateProduct(Request $request)
	{
		Log::info('[ProductController/CreateProduct]');
		$requestContent = json_decode($request->getContent(), true);
		$validator = ProductBindingViewModel::validate($requestContent[0]);	
		
		if($validator->fails()){			
			Log::info("validator fails message = ".$validator->messages()) ;
			return $validator->messages();
		}else{
			$ProductBindingViewModel = new ProductBindingViewModel();
			$ProductBindingViewModel->fill($requestContent[0]);
			return (new ProductModel())->CreateProduct($ProductBindingViewModel);			
		}
	}

	// Retrieve
	public function SelectProductWithoutPager(Request $request)
	{
		Log::info('[ProductController/SelectProductWithoutPager]');
		$requestContent = json_decode($request->getContent(), true);
		$validator = ProductCriteriaViewModel::validate($requestContent[0]);	

		if($validator->fails()){			
			Log::info("[ProductController/SelectProductWithoutPager] validator fails message = ".$validator->messages()) ;
			return $validator->messages();
		}else{
			$ProductCriteriaViewModel = new ProductCriteriaViewModel();
			$ProductCriteriaViewModel->fill($requestContent[0]);
			return (new ProductModel())->SelectProductWithoutPager($ProductCriteriaViewModel);			
		}
		
		//return (new ProductModel())->SelectProductByProductName($ProductName);
	}
	public function SelectProductWithPager(Request $request)
	{
		Log::info('[ProductController/SelectProductWithPager]');		
		$requestContent = json_decode($request->getContent(), true);		
		$validator = ProductCriteriaViewModel::validate($requestContent[0]);	

		if($validator->fails()){			
			Log::info("[ProductController/SelectProductWithPager] validator fails message = ".$validator->messages()) ;
			return $validator->messages();
		}else{
			$ProductCriteriaViewModel = new ProductCriteriaViewModel();			
			$ProductCriteriaViewModel->fill($requestContent[0]);
			return (new ProductModel())->SelectProductWithPager($ProductCriteriaViewModel);			
		}
	}
	
	// Update
	// Delete
}
