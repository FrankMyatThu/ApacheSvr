<?php

namespace App\Model\BusinessLogic;

use App\Model\ViewModel\OrderViewModel_Binding;
use App\Model\ViewModel\OrderViewModel_Criteria;
use App\Model\ViewModel\OrderDetailViewModel_Binding;
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
    public function SelectOrderWithPager(OrderViewModel_Criteria $OrderViewModel_Criteria)
    {
        Log::info("[Order_BL/SelectOrderWithPager] Start");
        try {
            $tbl_GridListing = new CommonViewModel_tbl_GridListing();                        
            $query = DB::table(DB::raw('Orders, (SELECT @row := 0) RowCounter'));
            $query = $query->select(
                                DB::raw('@row := @row + 1 AS SrNo'),                                                              
                                'OrderId',                                 
                                'Description',
                                'OrderDate'                                
                            );
            
            // where clauses
            if(!$this->IsNullOrEmptyString($OrderViewModel_Criteria->getAttribute('OrderId'))){
                $query = $query->where('OrderId', trim($OrderViewModel_Criteria->getAttribute('OrderId')));
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
            // ----Bind data to tbl_Pager_To_Client
            //$tbl_GridListing->List_tbl_Pager_To_Client = "";            
            $TotalPage = ceil($TotalRecordCount / $OrderViewModel_Criteria->getAttribute('RecordPerPage'));
            $Pager_BatchIndex = 1;
            $Pager_BehindTheScenseIndex = 1;
            $List_tbl_Pager_To_Client = [];
            for ($i = 1; $i <= $TotalPage; $i++) {

                if($Pager_BehindTheScenseIndex > $OrderViewModel_Criteria->getAttribute('PagerShowIndexOneUpToX')){
                    $Pager_BehindTheScenseIndex = 1;
                }

                $tbl_Pager_To_Client = new CommonViewModel_tbl_Pager_To_Client();
                $tbl_Pager_To_Client->BatchIndex = $Pager_BatchIndex;
                $tbl_Pager_To_Client->DisplayPageIndex = $i;
                $tbl_Pager_To_Client->BehindTheScenesIndex = $Pager_BehindTheScenseIndex;
                $List_tbl_Pager_To_Client[] = $tbl_Pager_To_Client;

                $Pager_BehindTheScenseIndex++;

                if (($i % $OrderViewModel_Criteria->getAttribute('PagerShowIndexOneUpToX')) == 0)
                {
                    $Pager_BatchIndex++;
                }

            }
            $tbl_GridListing->List_tbl_Pager_To_Client = $List_tbl_Pager_To_Client;

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
                    Log::info("[Order_BL/SelectOrderWithPager] validator fails message = ".$validator->messages()) ;
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
            Log::error('[Order_BL/SelectOrderWithPager] Error = '.$e);
        }
    }       
    public function SelectOrderDetail(OrderViewModel_Criteria $OrderViewModel_Criteria)
    {
        Log::info("[Order_BL/SelectOrderDetail] Start");
        try {
            $tbl_GridListing = new CommonViewModel_tbl_GridListing();    

            /* Get master  query */ {                     
                $queryMaster = DB::table(DB::raw('Orders, (SELECT @row := 0) RowCounter'));
                $queryMaster = $queryMaster->select(
                                    DB::raw('@row := @row + 1 AS SrNo'),                                                              
                                    'OrderId',                                 
                                    'Description',
                                    'OrderDate'                                                                
                                );
                
                Log::info("OrderId = ".$OrderViewModel_Criteria->getAttribute('OrderId'));

                // where clauses
                if(!$this->IsNullOrEmptyString($OrderViewModel_Criteria->getAttribute('OrderId'))){
                    $queryMaster = $queryMaster->where('OrderId', trim($OrderViewModel_Criteria->getAttribute('OrderId')));
                }

                if(!$this->IsNullOrEmptyString($OrderViewModel_Criteria->getAttribute('Description'))){
                    $queryMaster = $queryMaster->where('Description', trim($OrderViewModel_Criteria->getAttribute('Description')));
                }

                if(!$this->IsNullOrEmptyString($OrderViewModel_Criteria->getAttribute('OrderDate'))){
                    $queryMaster = $queryMaster->where('OrderDate', trim($OrderViewModel_Criteria->getAttribute('OrderDate')));
                }

                // orderby clauses
                // ...            
                $OrderByArray = $this->GetOrderByArray(trim($OrderViewModel_Criteria->getAttribute('OrderByClause')));            
                foreach($OrderByArray as $rowArray) {
                    $queryMaster = $queryMaster->orderBy($rowArray[0], $rowArray[1]);    
                }

                // count clause
                $TotalRecordCount = $queryMaster->count();            
                $tbl_GridListing->TotalRecordCount = $TotalRecordCount;    

                $sqlLogMaster =   $queryMaster
                                ->take($OrderViewModel_Criteria->getAttribute('RecordPerBatch'))                
                                ->skip(($OrderViewModel_Criteria->getAttribute('BatchIndex') - 1) * $OrderViewModel_Criteria->getAttribute('RecordPerBatch'))
                                ->toSql();
                Log::info("queryMaster Log = ".$sqlLogMaster);

                $resultsMaster =  $queryMaster
                                ->take($OrderViewModel_Criteria->getAttribute('RecordPerBatch'))                
                                ->skip(($OrderViewModel_Criteria->getAttribute('BatchIndex') - 1) * $OrderViewModel_Criteria->getAttribute('RecordPerBatch'))
                                ->get();
            }
            
            /* Get detail query */ {
                $queryDetail = DB::table('OrderDetails');
                $queryDetail = $queryDetail->join('Products', 'OrderDetails.ProductID', '=', 'Products.ProductID');
                $queryDetail = $queryDetail->select(
                                    'OrderDetails.OrderDetailID',                                 
                                    'OrderDetails.OrderId',
                                    'OrderDetails.ProductID',
                                    'Products.ProductName',
                                    'OrderDetails.Quantity',
                                    'OrderDetails.Total',
                                    'OrderDetails.TotalGST'
                                );
                
                // where clauses
                if(!$this->IsNullOrEmptyString($OrderViewModel_Criteria->getAttribute('OrderId'))){
                    $queryDetail = $queryDetail->where('OrderDetails.OrderId', trim($OrderViewModel_Criteria->getAttribute('OrderId')));
                }
                
                $sqlLogDetail =  $queryDetail->toSql();
                Log::info("queryDetail Log = ".$sqlLogDetail);

                $resultsDetail =  $queryDetail->get();
            }
            
            /* Get list combining master and detail */ {
                // Bind tbl_GridListing
                // ----Bind data to List_Data
                //$tbl_GridListing->List_Data = "";
                
                $List_OrderMasterDetailBindingViewModel = [ "Master" => "", "Detail" => "" ];
                $OrderViewModel_Binding = new OrderViewModel_Binding();
                log::info("resultsMaster = ".print_r($resultsMaster[0], true));
                $OrderViewModel_Binding->fill((array)$resultsMaster[0]);
                $List_OrderMasterDetailBindingViewModel["Master"] = $OrderViewModel_Binding;
                
                $List_OrderDetailViewModel_Binding = [];
                foreach ($resultsDetail as $resultDetail) {
                    $OrderDetailViewModel_Binding = new OrderDetailViewModel_Binding();
                    log::info("resultDetail = ".print_r($resultDetail, true));
                    $OrderDetailViewModel_Binding->fill((array)$resultDetail);
                    $List_OrderDetailViewModel_Binding[] = $OrderDetailViewModel_Binding;
                }
                $List_OrderMasterDetailBindingViewModel["Detail"] = $List_OrderDetailViewModel_Binding;
                $tbl_GridListing->List_Data = $List_OrderMasterDetailBindingViewModel;
            }
            
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
                ->where( array('OrderId' => trim($OrderViewModel_Binding->getAttribute('OrderId'))) )
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
                    array('OrderId' => trim($OrderViewModel_Binding->getAttribute('OrderId')) )
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