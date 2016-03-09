<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\ProductModel;
use Log;

class ProductController extends Controller
{
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
}
