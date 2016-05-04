<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\BusinessLogic\Order_BL;
use App\Model\ViewModel\OrderDetailViewModel_Binding;
use App\Model\ViewModel\OrderViewModel_Binding;
use App\Model\ViewModel\OrderViewModel_Criteria;


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
			
			/* Binding master and detail models */ {
                // Bind Master model
				$OrderViewModel_Binding = new OrderViewModel_Binding();
				$OrderViewModel_Binding->fill($requestContent[0]);
				Log::info("OrderViewModel_Binding = ".print_r($OrderViewModel_Binding->toArray(), true));

				Log::info("Detail count = ".count($requestContent[0]["OrderDetails"]));			
                /*Binding Detail model*/{
					// Bind Detail model                	
					$List_OrderDetailViewModel_Binding = [];
					foreach ($requestContent[0]["OrderDetails"] as $ItemRow) {
						$OrderDetailViewModel_Binding = new OrderDetailViewModel_Binding();
						$OrderDetailViewModel_Binding->fill($ItemRow);	
						$List_OrderDetailViewModel_Binding[] = $OrderDetailViewModel_Binding;
						Log::info("OrderDetailViewModel_Binding = ".print_r($OrderDetailViewModel_Binding->toArray(), true));
					}		
                }
			}
			return (new Order_BL())->CreateOrder($OrderViewModel_Binding, $List_OrderDetailViewModel_Binding);			
		}
	}

	// Retrieve
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
	public function SelectOrderDetail(Request $request)
	{
		Log::info("[OrderController/SelectOrderDetail]");
		$requestContent = json_decode($request->getContent(), true);
		$validator = OrderViewModel_Criteria::validate($requestContent[0]);	

		if($validator->fails()){			
			Log::info("[OrderController/SelectOrderDetail] validator fails message = ".$validator->messages()) ;
			return $validator->messages();
		}else{
			$OrderViewModel_Criteria = new OrderViewModel_Criteria();
			Log::info("requestContent = ".print_r($requestContent[0], true));
			$OrderViewModel_Criteria->fill($requestContent[0]);
			return (new Order_BL())->SelectOrderDetail($OrderViewModel_Criteria);			
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
		$validator = OrderViewModel_Criteria::validate($requestContent[0]);	
		
		if($validator->fails()){			
			Log::info("[OrderController/DeleteOrder] validator fails message = ".$validator->messages()) ;
			return $validator->messages();
		}else{
			$OrderViewModel_Criteria = new OrderViewModel_Criteria();
			$OrderViewModel_Criteria->fill($requestContent[0]);
			return (new Order_BL())->DeleteOrder($OrderViewModel_Criteria);			
		}
	}
}
