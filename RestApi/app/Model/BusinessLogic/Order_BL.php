<?php

namespace App\Model\BusinessLogic;

use App\Model\ViewModel\OrderViewModel_Binding;
use App\Model\ViewModel\OrderViewModel_Criteria;
use App\Model\ViewModel\CommonViewModel_tbl_GridListing;
use App\Model\ViewModel\CommonViewModel_tbl_Pager_To_Client;
use Log;
use DB;

class Order_BL
{    
    // Create
    public function CreateOrder(OrderViewModel_Binding $OrderViewModel_Binding)
    {
        Log::info("[Order_BL/CreateOrder] Start ........");
        try {

            //DB::enableQueryLog();
            DB::table('Orders')->insert(
                 array(
                        'OrderName'       =>   trim($OrderViewModel_Binding->getAttribute('OrderName')), 
                        'Description'     =>   trim($OrderViewModel_Binding->getAttribute('Description')),
                        'Price'           =>   trim($OrderViewModel_Binding->getAttribute('Price'))
                 )
            );
            //Log::info("Query Log = ". print_r(DB::getQueryLog(), true));

            return "Success";
        }
        catch(Exception $e) {
            Log::error('[Order_BL/CreateOrder] Error = '.$e);
        }
    }

    // Retrieve
    public function SelectOrderWithoutPager(OrderViewModel_Criteria $OrderViewModel_Criteria)
    {
        Log::info("[Order_BL/SelectOrderWithoutPager] Start");
        try {
            $tbl_GridListing = new CommonViewModel_tbl_GridListing();                        
            $query = DB::table(DB::raw('Orders, (SELECT @row := 0) RowCounter'));
            $query = $query->select(
                                DB::raw('@row := @row + 1 AS SrNo'),                                                              
                                'OrderID',                                 
                                'Description',
                                'OrderDate'                                
                            );
            
            // where clauses
            if(!$this->IsNullOrEmptyString($OrderViewModel_Criteria->getAttribute('OrderID'))){
                $query = $query->where('OrderID', trim($OrderViewModel_Criteria->getAttribute('OrderID')));
            }

            if(!$this->IsNullOrEmptyString($OrderViewModel_Criteria->getAttribute('Description'))){
                $query = $query->where('Description', trim($OrderViewModel_Criteria->getAttribute('Description')));
            }

            if(!$this->IsNullOrEmptyString($OrderViewModel_Criteria->getAttribute('OrderDate'))){
                $query = $query->where('OrderDate', trim($OrderViewModel_Criteria->getAttribute('OrderDate')));
            }

            // orderby clauses
            // ...            
            $OrderByArray = $this->GetOrderByArray(trim($OrderViewModel_Criteria->getAttribute('OrderByClause')));            
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
                            ->take($OrderViewModel_Criteria->getAttribute('RecordPerBatch'))                
                            ->skip(($OrderViewModel_Criteria->getAttribute('BatchIndex') - 1) * $OrderViewModel_Criteria->getAttribute('RecordPerBatch'))
                            ->toSql();
            //Log::info("Query Log = ".$sqlLog);

            $results =  $query
                            ->take($OrderViewModel_Criteria->getAttribute('RecordPerBatch'))                
                            ->skip(($OrderViewModel_Criteria->getAttribute('BatchIndex') - 1) * $OrderViewModel_Criteria->getAttribute('RecordPerBatch'))
                            ->get();

            $List_OrderBindingViewModel = [];
            foreach ($results as $result) {
                $OrderViewModel_Binding = new OrderViewModel_Binding();
                $validator = OrderViewModel_Binding::validate((array)$result);
                if($validator->fails()){            
                    Log::info("[Order_BL/SelectOrderWithoutPager] validator fails message = ".$validator->messages()) ;
                    return $validator->messages();
                }else{
                    $OrderViewModel_Binding->fill((array)$result); 
                    $List_OrderBindingViewModel[] = $OrderViewModel_Binding;
                }
            }

            $tbl_GridListing->List_Data = $List_OrderBindingViewModel;
            return json_encode((array)$tbl_GridListing);
        }
        catch(Exception $e) {
            Log::error('[Order_BL/SelectOrderWithoutPager] Error = '.$e);
        }
    }       
    public function SelectOrderDetail(OrderViewModel_Criteria $OrderViewModel_Criteria)
    {
        Log::info("[Order_BL/SelectOrderDetail] Start");
        try {
            $tbl_GridListing = new CommonViewModel_tbl_GridListing();                        
            $query = DB::table(DB::raw('Orders, (SELECT @row := 0) RowCounter'));
            $query = $query->select(
                                DB::raw('@row := @row + 1 AS SrNo'),                                                              
                                'OrderID',                                 
                                'Description',
                                'OrderDate'                                
                            );
            
            // where clauses
            if(!$this->IsNullOrEmptyString($OrderViewModel_Criteria->getAttribute('OrderID'))){
                $query = $query->where('OrderID', trim($OrderViewModel_Criteria->getAttribute('OrderID')));
            }

            if(!$this->IsNullOrEmptyString($OrderViewModel_Criteria->getAttribute('Description'))){
                $query = $query->where('Description', trim($OrderViewModel_Criteria->getAttribute('Description')));
            }

            if(!$this->IsNullOrEmptyString($OrderViewModel_Criteria->getAttribute('OrderDate'))){
                $query = $query->where('OrderDate', trim($OrderViewModel_Criteria->getAttribute('OrderDate')));
            }

            // orderby clauses
            // ...            
            $OrderByArray = $this->GetOrderByArray(trim($OrderViewModel_Criteria->getAttribute('OrderByClause')));            
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
                            ->take($OrderViewModel_Criteria->getAttribute('RecordPerBatch'))                
                            ->skip(($OrderViewModel_Criteria->getAttribute('BatchIndex') - 1) * $OrderViewModel_Criteria->getAttribute('RecordPerBatch'))
                            ->toSql();
            //Log::info("Query Log = ".$sqlLog);

            $results =  $query
                            ->take($OrderViewModel_Criteria->getAttribute('RecordPerBatch'))                
                            ->skip(($OrderViewModel_Criteria->getAttribute('BatchIndex') - 1) * $OrderViewModel_Criteria->getAttribute('RecordPerBatch'))
                            ->get();

            $List_OrderBindingViewModel = [];
            foreach ($results as $result) {
                $OrderViewModel_Binding = new OrderViewModel_Binding();
                $validator = OrderViewModel_Binding::validate((array)$result);
                if($validator->fails()){            
                    Log::info("[Order_BL/SelectOrderDetail] validator fails message = ".$validator->messages()) ;
                    return $validator->messages();
                }else{
                    $OrderViewModel_Binding->fill((array)$result); 
                    $List_OrderBindingViewModel[] = $OrderViewModel_Binding;
                }
            }

            $tbl_GridListing->List_Data = $List_OrderBindingViewModel;
            return json_encode((array)$tbl_GridListing);
        }
        catch(Exception $e) {
            Log::error('[Order_BL/SelectOrderDetail] Error = '.$e);
        }
    } 
    
    // Update
    public function UpdateOrder(OrderViewModel_Binding $OrderViewModel_Binding)
    {
        Log::info("[Order_BL/UpdateOrder] Start ........");
        try {
            
            //DB::enableQueryLog();
            DB::table('Orders')
                ->where( array('OrderID' => trim($OrderViewModel_Binding->getAttribute('OrderID'))) )
                ->update(
                        array(
                            'OrderName'     =>   trim($OrderViewModel_Binding->getAttribute('OrderName')), 
                            'Description'     =>   trim($OrderViewModel_Binding->getAttribute('Description')),
                            'Price'           =>   trim($OrderViewModel_Binding->getAttribute('Price'))
                        )
                    );
            //Log::info("Query Log = ". print_r(DB::getQueryLog(), true));

            return "Success";
        }
        catch(Exception $e) {
            Log::error('[Order_BL/UpdateOrder] Error = '.$e);
        }
    }

    // Delete
    public function DeleteOrder(OrderViewModel_Binding $OrderViewModel_Binding)
    {
        Log::info("[Order_BL/DeleteOrder] Start ........");
        try {
            
            //DB::enableQueryLog();
            DB::table('Orders')->where(
                    array('OrderID' => trim($OrderViewModel_Binding->getAttribute('OrderID')) )
                )->delete();
            //Log::info("Query Log = ". print_r(DB::getQueryLog(), true));
        
            return "Success";
        }
        catch(Exception $e) {
            Log::error('[Order_BL/DeleteOrder] Error = '.$e);
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