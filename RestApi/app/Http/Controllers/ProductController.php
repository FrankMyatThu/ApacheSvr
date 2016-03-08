<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\ProductModel;

class ProductController extends Controller
{
    public function SelectProductAll()
	{
		return (new ProductModel())->SelectProductAll();
	}

	public function SelectProductByProductName($ProductName)
	{
		return (new ProductModel())->SelectProductByProductName($ProductName);
	}
}