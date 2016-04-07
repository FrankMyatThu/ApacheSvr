<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\BusinessLogic\Product_BL;
use App\Model\ViewModel\ProductViewModel_Binding;
use App\Model\ViewModel\ProductViewModel_Criteria;
use Log;

class ProductController extends Controller
{
	// Create	
    public function CreateProduct(Request $request)
	{
		Log::info("[ProductController/CreateProduct]");
		$requestContent = json_decode($request->getContent(), true);
		$validator = ProductViewModel_Binding::validate($requestContent[0]);	
		
		if($validator->fails()){			
			Log::info("[ProductController/CreateProduct] validator fails message = ".$validator->messages()) ;
			return $validator->messages();
		}else{
			$ProductViewModel_Binding = new ProductViewModel_Binding();
			$ProductViewModel_Binding->fill($requestContent[0]);
			return (new Product_BL())->CreateProduct($ProductViewModel_Binding);			
		}
	}

	// Retrieve
	public function SelectProductWithPager(Request $request)
	{
		Log::info("[ProductController/SelectProductWithPager]");		
		$requestContent = json_decode($request->getContent(), true);		
		$validator = ProductViewModel_Criteria::validate($requestContent[0]);	

		if($validator->fails()){			
			Log::info("[ProductController/SelectProductWithPager] validator fails message = ".$validator->messages()) ;
			return $validator->messages();
		}else{
			$ProductViewModel_Criteria = new ProductViewModel_Criteria();			
			$ProductViewModel_Criteria->fill($requestContent[0]);
			return (new Product_BL())->SelectProductWithPager($ProductViewModel_Criteria);			
		}
	}
	public function SelectProductWithoutPager(Request $request)
	{
		Log::info("[ProductController/SelectProductWithoutPager]");
		$requestContent = json_decode($request->getContent(), true);
		$validator = ProductViewModel_Criteria::validate($requestContent[0]);	

		if($validator->fails()){			
			Log::info("[ProductController/SelectProductWithoutPager] validator fails message = ".$validator->messages()) ;
			return $validator->messages();
		}else{
			$ProductViewModel_Criteria = new ProductViewModel_Criteria();
			$ProductViewModel_Criteria->fill($requestContent[0]);
			return (new Product_BL())->SelectProductWithoutPager($ProductViewModel_Criteria);			
		}
	}	
	
	// Update
	public function UpdateProduct(Request $request)
	{
		Log::info("[ProductController/UpdateProduct]");
		$requestContent = json_decode($request->getContent(), true);
		$validator = ProductViewModel_Binding::validate($requestContent[0]);	
		
		if($validator->fails()){			
			Log::info("[ProductController/UpdateProduct] validator fails message = ".$validator->messages()) ;
			return $validator->messages();
		}else{
			$ProductViewModel_Binding = new ProductViewModel_Binding();
			$ProductViewModel_Binding->fill($requestContent[0]);
			return (new Product_BL())->UpdateProduct($ProductViewModel_Binding);			
		}
	}

	// Delete
	public function DeleteProduct(Request $request)
	{
		Log::info("[ProductController/DeleteProduct]");
		$requestContent = json_decode($request->getContent(), true);
		$validator = ProductViewModel_Binding::validate($requestContent[0]);	
		
		if($validator->fails()){			
			Log::info("[ProductController/DeleteProduct] validator fails message = ".$validator->messages()) ;
			return $validator->messages();
		}else{
			$ProductViewModel_Binding = new ProductViewModel_Binding();
			$ProductViewModel_Binding->fill($requestContent[0]);
			return (new Product_BL())->DeleteProduct($ProductViewModel_Binding);			
		}
	}
}
