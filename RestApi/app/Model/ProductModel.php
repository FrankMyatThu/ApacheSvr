<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\ViewModel\ProductBindingViewModel;
use App\ViewModel\ProductCriteriaViewModel;
use App\ViewModel\CommonViewModel;
use Log;

class ProductModel extends Model
{
    public $table = 'Products';
    public $timestamps = false;
    
    // Create
    public function CreateProduct(ProductBindingViewModel $ProductBindingViewModel)
    {
        Log::info("[ProductModel/CreateProduct] Start");
        try {
            $ProductModel = new ProductModel;
            $ProductModel->ProductName = $ProductBindingViewModel->getAttribute('ProductName');
            $ProductModel->Description = $ProductBindingViewModel->getAttribute('Description');
            $ProductModel->Price = $ProductBindingViewModel->getAttribute('Price');
            $ProductModel->save();
            return "Success";
        }
        catch(Exception $e) {
            Log::error('[ProductModel/Create] Error = '.$e);
        }
    }

    // Retrieve
    public function SelectProductWithoutPager(ProductCriteriaViewModel $ProductCriteriaViewModel)
    {
        Log::info("[ProductModel/SelectProductWithoutPager] Start");
        try {
            //$OrderByClause = $ProductCriteriaViewModel->getAttribute('OrderByClause'); // Make ASC, Year DESC  
            $query = $this::query();
            
            // where clauses
            if(!IsNullOrEmptyString($ProductCriteriaViewModel->getAttribute('ProductID'))){
                $query = $query->where('ProductID', trim($ProductCriteriaViewModel->getAttribute('ProductID')));
            }

            if(!IsNullOrEmptyString($ProductCriteriaViewModel->getAttribute('ProductName'))){
                $query = $query->where('ProductName', trim($ProductCriteriaViewModel->getAttribute('ProductName')));
            }
            
            if(!IsNullOrEmptyString($ProductCriteriaViewModel->getAttribute('Description'))){
                $query = $query->where('Description', trim($ProductCriteriaViewModel->getAttribute('Description')));
            }

            // orderby clauses
            // ...

            // count clause
            $queryCount = $query->count();

            $results = $query->get();


            return $results;
        }
        catch(Exception $e) {
            Log::error('[ProductModel/Create] Error = '.$e);
        }
    }
    public function SelectProductWithPager(ProductCriteriaViewModel $ProductCriteriaViewModel)
    {
        Log::info("[ProductModel/SelectProductWithoutPager] Start");
        try {
            $tbl_GridListing = new tbl_GridListing();
            //$OrderByClause = $ProductCriteriaViewModel->getAttribute('OrderByClause'); // Make ASC, Year DESC  
            $query = $this::query();
            
            // where clauses
            if(!IsNullOrEmptyString($ProductCriteriaViewModel->getAttribute('ProductID'))){
                $query = $query->where('ProductID', trim($ProductCriteriaViewModel->getAttribute('ProductID')));
            }

            if(!IsNullOrEmptyString($ProductCriteriaViewModel->getAttribute('ProductName'))){
                $query = $query->where('ProductName', trim($ProductCriteriaViewModel->getAttribute('ProductName')));
            }
            
            if(!IsNullOrEmptyString($ProductCriteriaViewModel->getAttribute('Description'))){
                $query = $query->where('Description', trim($ProductCriteriaViewModel->getAttribute('Description')));
            }

            // orderby clauses
            // ...

            // count clause
            $queryCount = $query->count();

            // Bind tbl_GridListing
            // ----Bind data to tbl_Pager_To_Client
            $tbl_GridListing->List_tbl_Pager_To_Client = "";            


            // Bind tbl_GridListing
            // ----Bind data to List_Data
            $tbl_GridListing->List_Data = "";



            $results = $query->get();


            return $results;
        }
        catch(Exception $e) {
            Log::error('[ProductModel/Create] Error = '.$e);
        }
    }    
    public function SelectProductAll()
    {    	
        Log::info('[ProductModel][SelectProductAll()]');
        Log::info('[ProductModel][SelectProductAll()]Products...');
    	return $this::all();    	
    }    
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

    // Helpers    
    function IsNullOrEmptyString($value){
        return (!isset($value) || trim($value)==='');
    }
}
