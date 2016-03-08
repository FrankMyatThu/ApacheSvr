<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Log;

class ProductModel extends Model
{
    public $table = 'products';

    // Create
    // Retrieve
    public function SelectProductAll()
    {    	
        Log::info('[ProductModel][SelectProductAll()]');
    	return $this::all();    	
    }

    // Retrieve
    public function SelectProductByProductName($ProductName)
    {
        Log::info('[ProductModel][SelectProductByProductName()]');
        
        //return $this::where('ProductID' , '=', 1)->first();
        //return $this::where('ProductID' , '=', 2)->get();
        //return $this::where('ProductName' , 'like', '%'.$ProductName.'%')->get();

        Log::info('$ProductName: '.$ProductName);
        $query = $this::where('ProductName' , 'like', '%'.$ProductName.'%');

        //if (this == that) {
        //  $query = $query->where('this', 'that);
        //}

        //if (this == another_thing) {
        //  $query = $query->where('this', 'another_thing');
        //}

        $results = $query->get();
        return $results;
    }

    // Update
    // Delete
}
