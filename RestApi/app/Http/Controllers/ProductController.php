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
		Log::info('[ProductController/Create]');
		
		//$requestContent = json_decode($request->getContent());
		$requestContent = $request->getContent();

		$validation = ProductViewModel::validate($requestContent);	
		Log::info('$validation ' . $validation->messages());	

		if($validation->fails()){
			Log::info('fails');
			return "fails";
		}else{
			return (new ProductModel())->CreateProduct($requestContent);			
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
