<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;

class OrderController extends Controller
{
	// Create	
    public function CreateOrder(Request $request)
	{
		Log::info("[OrderController/CreateOrder]");
		$requestContent = json_decode($request->getContent(), true);
		$validator = OrderViewModel_Binding::validate($requestContent[0]);	
		
		if($validator->fails()){			
			Log::info("[OrderController/CreateOrder] validator fails message = ".$validator->messages()) ;
			return $validator->messages();
		}else{
			$OrderViewModel_Binding = new OrderViewModel_Binding();
			$OrderViewModel_Binding->fill($requestContent[0]);
			return (new Order_BL())->CreateOrder($OrderViewModel_Binding);			
		}
	}

	// Retrieve
	public function SelectOrderWithoutPager(Request $request)
	{
		Log::info("[OrderController/SelectOrderWithoutPager]");
		$requestContent = json_decode($request->getContent(), true);
		$validator = OrderViewModel_Criteria::validate($requestContent[0]);	

		if($validator->fails()){			
			Log::info("[OrderController/SelectOrderWithoutPager] validator fails message = ".$validator->messages()) ;
			return $validator->messages();
		}else{
			$OrderViewModel_Criteria = new OrderViewModel_Criteria();
			$OrderViewModel_Criteria->fill($requestContent[0]);
			return (new Order_BL())->SelectOrderWithoutPager($OrderViewModel_Criteria);			
		}
	}
	public function SelectOrderWithPager(Request $request)
	{
		Log::info("[OrderController/SelectOrderWithPager]");		
		$requestContent = json_decode($request->getContent(), true);		
		$validator = OrderViewModel_Criteria::validate($requestContent[0]);	

		if($validator->fails()){			
			Log::info("[OrderController/SelectOrderWithPager] validator fails message = ".$validator->messages()) ;
			return $validator->messages();
		}else{
			$OrderViewModel_Criteria = new OrderViewModel_Criteria();			
			$OrderViewModel_Criteria->fill($requestContent[0]);
			return (new Order_BL())->SelectOrderWithPager($OrderViewModel_Criteria);			
		}
	}
	
	// Update
	public function UpdateOrder(Request $request)
	{
		Log::info("[OrderController/UpdateOrder]");
		$requestContent = json_decode($request->getContent(), true);
		$validator = OrderViewModel_Binding::validate($requestContent[0]);	
		
		if($validator->fails()){			
			Log::info("[OrderController/UpdateOrder] validator fails message = ".$validator->messages()) ;
			return $validator->messages();
		}else{
			$OrderViewModel_Binding = new OrderViewModel_Binding();
			$OrderViewModel_Binding->fill($requestContent[0]);
			return (new Order_BL())->UpdateOrder($OrderViewModel_Binding);			
		}
	}

	// Delete
	public function DeleteOrder(Request $request)
	{
		Log::info("[OrderController/DeleteOrder]");
		$requestContent = json_decode($request->getContent(), true);
		$validator = OrderViewModel_Binding::validate($requestContent[0]);	
		
		if($validator->fails()){			
			Log::info("[OrderController/DeleteOrder] validator fails message = ".$validator->messages()) ;
			return $validator->messages();
		}else{
			$OrderViewModel_Binding = new OrderViewModel_Binding();
			$OrderViewModel_Binding->fill($requestContent[0]);
			return (new Order_BL())->DeleteOrder($OrderViewModel_Binding);			
		}
	}
}
