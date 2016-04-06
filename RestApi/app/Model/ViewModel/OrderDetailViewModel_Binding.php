<?php

namespace App\Model\ViewModel;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Log;

// To bind data
class OrderDetailViewModel_Binding extends Model
{
	protected $fillable = array(		
						 	'OrderDetailID',						 	
						 	'OrderId',
						 	'ProductID',
						 	'ProductName',
						 	'Quantity',
						 	'Total',
						 	'TotalGST'
						   );	
}