<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\ViewModel\ProductViewModel;
use Log;

class ProductModel extends Model
{
    public $table = 'Products';
    public $timestamps = false;
    
    // Create
    public function CreateProduct(ProductViewModel $ProductViewModel)
    {
        try {
            $ProductModel = new ProductModel;
            $ProductModel->ProductName = $ProductViewModel->ProductName;
            $ProductModel->Description = $ProductViewModel->Description;
            $ProductModel->Price = $ProductViewModel->Price;
            $ProductModel->save();
            return "Product is successfully created.";
        }
        catch(Exception $e) {
            Log::error('[ProductModel/Create]'.$e);
        }
    }

    // Retrieve
    public function SelectProductAll()
    {    	
        Log::info('[ProductModel][SelectProductAll()]');
        Log::info('[ProductModel][SelectProductAll()]Products...');
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
