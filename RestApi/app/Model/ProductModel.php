<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    public $table = 'products';

    // Create
    // Retrieve
    public function SelectProduct()
    {    	
    	return $this::all();
    	//return "***";
    }

    // Update
    // Delete
}
