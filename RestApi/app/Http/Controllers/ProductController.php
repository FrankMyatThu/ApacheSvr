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
			return "fails";
		}else{
			$ProductViewModel = new ProductViewModel();
			$ProductViewModel->fill($requestContent[0]);
			// create model to json conversion.
			Log::info("ProductViewModel Json = ".$ProductViewModel->toJson());
			return "success";
			//return (new ProductModel())->CreateProduct($ProductViewModel);			
		}
	}

	// Retrieve
	public function SelectProductAll()
	{
		Log::info('[ProductController][SelectProductAll()]');
		return (new ProductModel())->SelectProductAll();
	}
	public function SelectProductByProductName($ProductName)
	{
		Log::info('[ProductController][SelectProductByProductName()]');
		return (new ProductModel())->SelectProductByProductName($ProductName);
	}
	
	// Update
	// Delete
}
