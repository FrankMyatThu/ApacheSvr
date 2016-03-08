<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\ProductModel;

class ProductController extends Controller
{
    public function SelectProduct()
	{
		return (new ProductModel())->SelectProduct();
	}
}