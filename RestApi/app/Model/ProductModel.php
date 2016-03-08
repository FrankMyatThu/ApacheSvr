<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    public $table = 'products';

    // Create
    // Retrieve
    public function SelectProductAll()
    {    	
    	return $this::all();    	
    }

    // Retrieve
    public function SelectProductByProductName($ProductName)
    {
        //return $this::where('ProductID' , '=', 1)->first();
        //return $this::where('ProductID' , '=', 2)->get();
        //return $this::where('ProductName' , 'like', '%'.$ProductName.'%')->get();

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
