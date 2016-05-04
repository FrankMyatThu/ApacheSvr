<?php

namespace App\Model\BusinessLogic;

use App\Model\ViewModel\ProductViewModel_Binding;
use App\Model\ViewModel\ProductViewModel_Criteria;
use App\Model\ViewModel\CommonViewModel_tbl_GridListing;
use App\Model\ViewModel\CommonViewModel_tbl_Pager_To_Client;
use Log;
use DB;

class Product_BL
{    
    // Create
    public function CreateProduct(ProductViewModel_Binding $ProductViewModel_Binding)
    {
        Log::info("[Product_BL/CreateProduct] Start ........");
        try {

            //DB::enableQueryLog();
            DB::table('Products')->insert(
                 array(
                        'ProductName'     =>   trim($ProductViewModel_Binding->getAttribute('ProductName')), 
                        'Description'     =>   trim($ProductViewModel_Binding->getAttribute('Description')),
                        'Price'           =>   trim($ProductViewModel_Binding->getAttribute('Price'))
                 )
            );
            //Log::info("Query Log = ". print_r(DB::getQueryLog(), true));

            return "Success";
        }
        catch(Exception $e) {
            Log::error('[Product_BL/CreateProduct] Error = '.$e);
        }
    }

    // Retrieve
    public function SelectProductWithoutPager(ProductViewModel_Criteria $ProductViewModel_Criteria)
    {
        Log::info("[Product_BL/SelectProductWithoutPager] Start");
        try {
            $tbl_GridListing = new CommonViewModel_tbl_GridListing();                        
            $query = DB::table(DB::raw('Products, (SELECT @row := 0) RowCounter'));
            $query = $query->select(
                                DB::raw('@row := @row + 1 AS SrNo'),                                                              
                                'ProductID', 
                                'ProductName', 
                                'Description',
                                'Price',                 
                                 DB::raw('IFNULL(ProductImage,"") AS ProductImage')
                            );
            
            // where clauses
            if(!$this->IsNullOrEmptyString($ProductViewModel_Criteria->getAttribute('ProductID'))){
                $query = $query->where('ProductID', trim($ProductViewModel_Criteria->getAttribute('ProductID')));
            }

            if(!$this->IsNullOrEmptyString($ProductViewModel_Criteria->getAttribute('ProductName'))){
                $query = $query->where('ProductName', trim($ProductViewModel_Criteria->getAttribute('ProductName')));
            }
            
            if(!$this->IsNullOrEmptyString($ProductViewModel_Criteria->getAttribute('Description'))){
                $query = $query->where('Description', trim($ProductViewModel_Criteria->getAttribute('Description')));
            }

            // orderby clauses
            // ...            
            $OrderByArray = $this->GetOrderByArray(trim($ProductViewModel_Criteria->getAttribute('OrderByClause')));            
            foreach($OrderByArray as $rowArray) {
                $query = $query->orderBy($rowArray[0], $rowArray[1]);    
            }

            // count clause
            $TotalRecordCount = $query->count();            
            $tbl_GridListing->TotalRecordCount = $TotalRecordCount;
            
            // Bind tbl_GridListing
            // ----Bind data to List_Data
            //$tbl_GridListing->List_Data = "";
            $sqlLog =   $query
                            ->take($ProductViewModel_Criteria->getAttribute('RecordPerBatch'))                
                            ->skip(($ProductViewModel_Criteria->getAttribute('BatchIndex') - 1) * $ProductViewModel_Criteria->getAttribute('RecordPerBatch'))
                            ->toSql();
            //Log::info("Query Log = ".$sqlLog);

            $results =  $query
                            ->take($ProductViewModel_Criteria->getAttribute('RecordPerBatch'))                
                            ->skip(($ProductViewModel_Criteria->getAttribute('BatchIndex') - 1) * $ProductViewModel_Criteria->getAttribute('RecordPerBatch'))
                            ->get();

            $List_ProductBindingViewModel = [];
            foreach ($results as $result) {
                $ProductViewModel_Binding = new ProductViewModel_Binding();
                $ProductViewModel_Binding->fill((array)$result); 
                $List_ProductBindingViewModel[] = $ProductViewModel_Binding;
            }

            $tbl_GridListing->List_Data = $List_ProductBindingViewModel;
            return json_encode((array)$tbl_GridListing);
        }
        catch(Exception $e) {
            Log::error('[Product_BL/SelectProductWithoutPager] Error = '.$e);
        }
    }
    public function SelectProductWithPager(ProductViewModel_Criteria $ProductViewModel_Criteria)
    {
        Log::info("[Product_BL/SelectProductWithPager] Start");
        try {
            $tbl_GridListing = new CommonViewModel_tbl_GridListing();                        
            $query = DB::table(DB::raw('Products, (SELECT @row := 0) RowCounter'));
            $query = $query->select(
                                DB::raw('@row := @row + 1 AS SrNo'),                                                              
                                'ProductID', 
                                'ProductName', 
                                'Description',
                                'Price',                 
                                 DB::raw('IFNULL(ProductImage,"") AS ProductImage')
                            );
            
            // where clauses
            if(!$this->IsNullOrEmptyString($ProductViewModel_Criteria->getAttribute('ProductID'))){
                $query = $query->where('ProductID', trim($ProductViewModel_Criteria->getAttribute('ProductID')));
            }

            if(!$this->IsNullOrEmptyString($ProductViewModel_Criteria->getAttribute('ProductName'))){
                $query = $query->where('ProductName', trim($ProductViewModel_Criteria->getAttribute('ProductName')));
            }
            
            if(!$this->IsNullOrEmptyString($ProductViewModel_Criteria->getAttribute('Description'))){
                $query = $query->where('Description', trim($ProductViewModel_Criteria->getAttribute('Description')));
            }

            // orderby clauses
            // ...            
            $OrderByArray = $this->GetOrderByArray(trim($ProductViewModel_Criteria->getAttribute('OrderByClause')));            
            foreach($OrderByArray as $rowArray) {
                $query = $query->orderBy($rowArray[0], $rowArray[1]);    
            }

            // count clause
            $TotalRecordCount = $query->count();            
            $tbl_GridListing->TotalRecordCount = $TotalRecordCount;

            // Bind tbl_GridListing
            // ----Bind data to tbl_Pager_To_Client
            //$tbl_GridListing->List_tbl_Pager_To_Client = "";            
            $TotalPage = ceil($TotalRecordCount / $ProductViewModel_Criteria->getAttribute('RecordPerPage'));
            $Pager_BatchIndex = 1;
            $Pager_BehindTheScenseIndex = 1;
            $List_tbl_Pager_To_Client = [];
            for ($i = 1; $i <= $TotalPage; $i++) {

                if($Pager_BehindTheScenseIndex > $ProductViewModel_Criteria->getAttribute('PagerShowIndexOneUpToX')){
                    $Pager_BehindTheScenseIndex = 1;
                }

                $tbl_Pager_To_Client = new CommonViewModel_tbl_Pager_To_Client();
                $tbl_Pager_To_Client->BatchIndex = $Pager_BatchIndex;
                $tbl_Pager_To_Client->DisplayPageIndex = $i;
                $tbl_Pager_To_Client->BehindTheScenesIndex = $Pager_BehindTheScenseIndex;
                $List_tbl_Pager_To_Client[] = $tbl_Pager_To_Client;

                $Pager_BehindTheScenseIndex++;

                if (($i % $ProductViewModel_Criteria->getAttribute('PagerShowIndexOneUpToX')) == 0)
                {
                    $Pager_BatchIndex++;
                }

            }
            $tbl_GridListing->List_tbl_Pager_To_Client = $List_tbl_Pager_To_Client;

            // Bind tbl_GridListing
            // ----Bind data to List_Data
            //$tbl_GridListing->List_Data = "";
            $sqlLog =   $query
                            ->take($ProductViewModel_Criteria->getAttribute('RecordPerBatch'))                
                            ->skip(($ProductViewModel_Criteria->getAttribute('BatchIndex') - 1) * $ProductViewModel_Criteria->getAttribute('RecordPerBatch'))
                            ->toSql();
            Log::info("Query Log = ".$sqlLog);

            $results =  $query
                            ->take($ProductViewModel_Criteria->getAttribute('RecordPerBatch'))                
                            ->skip(($ProductViewModel_Criteria->getAttribute('BatchIndex') - 1) * $ProductViewModel_Criteria->getAttribute('RecordPerBatch'))
                            ->get();

            $List_ProductBindingViewModel = [];
            foreach ($results as $result) {
                $ProductViewModel_Binding = new ProductViewModel_Binding();
                $ProductViewModel_Binding->fill((array)$result); 
                $List_ProductBindingViewModel[] = $ProductViewModel_Binding;
            }

            $tbl_GridListing->List_Data = $List_ProductBindingViewModel;
            return json_encode((array)$tbl_GridListing);
        }
        catch(Exception $e) {
            Log::error('[Product_BL/SelectProductWithPager] Error = '.$e);
        }
    }   
    
    // Update
    public function UpdateProduct(ProductViewModel_Binding $ProductViewModel_Binding)
    {
        Log::info("[Product_BL/UpdateProduct] Start ........");
        try {
            
            //DB::enableQueryLog();
            DB::table('Products')
                ->where( array('ProductID' => trim($ProductViewModel_Binding->getAttribute('ProductID'))) )
                ->update(
                        array(
                            'ProductName'     =>   trim($ProductViewModel_Binding->getAttribute('ProductName')), 
                            'Description'     =>   trim($ProductViewModel_Binding->getAttribute('Description')),
                            'Price'           =>   trim($ProductViewModel_Binding->getAttribute('Price'))
                        )
                    );
            //Log::info("Query Log = ". print_r(DB::getQueryLog(), true));

            return "Success";
        }
        catch(Exception $e) {
            Log::error('[Product_BL/UpdateProduct] Error = '.$e);
        }
    }

    // Delete
    public function DeleteProduct(ProductViewModel_Criteria $ProductViewModel_Criteria)
    {
        Log::info("[Product_BL/DeleteProduct] Start ........");
        try {
            
            //DB::enableQueryLog();
            DB::table('Products')->where(
                    array('ProductID' => trim($ProductViewModel_Criteria->getAttribute('ProductID')) )
                )->delete();
            //Log::info("Query Log = ". print_r(DB::getQueryLog(), true));
        
            return "Success";
        }
        catch(Exception $e) {
            Log::error('[Product_BL/DeleteProduct] Error = '.$e);
        }
    }

    // Helpers    
    function IsNullOrEmptyString($value){
        return (!isset($value) || trim($value)==='');
    }
    function GetOrderByArray($value){
        $OrderByArray = explode(',', $value);
        $OrderByArrayToReturn = []; 
        foreach ($OrderByArray as $rowArray) {            
            $columnArray = explode(' ', trim($rowArray));            
            $OrderByArrayToReturn[] = array($columnArray[0], $columnArray[1]);
        }
        return $OrderByArrayToReturn;
    }
}
