<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\ProductModel;
use App\ViewModel\ProductViewModel;
use Log;

class ProductController extends Controller
{
	// Create	
    public function CreateProduct(Request $request)
	{
		Log::info('[ProductController/CreateProduct]');
		$requestContent = json_decode($request->getContent(), true);
		$validation = ProductViewModel::validate($requestContent);	
		
		if($validation->fails()){			
			Log::info("validator fails message = ".$validator->messages()) ;
			return $validator->messages();
		}else{
			$ProductViewModel = new ProductViewModel();
			$ProductViewModel->fill($requestContent[0]);
			return (new ProductModel())->CreateProduct($ProductViewModel);			
		}
	}

	// Retrieve
	public function SelectProductWithoutPager(Request $request)
	{
		Log::info('[ProductController/SelectProductWithoutPager]');
		$requestContent = json_decode($request->getContent(), true);
		//return (new ProductModel())->SelectProductByProductName($ProductName);
	}
	public function SelectProductWithPager()
	{
		Log::info('[ProductController][SelectProductAll()]');
		return (new ProductModel())->SelectProductAll();
	}
	
	// Update
	// Delete
}
