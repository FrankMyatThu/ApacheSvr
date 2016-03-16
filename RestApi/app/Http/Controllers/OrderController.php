<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;

class OrderController extends Controller
{
    public function SelectOrderAll()
	{
		Log::info('[OrderController][SelectOrderAll()]');
		return "SelectOrderAll ...";
	}
}
