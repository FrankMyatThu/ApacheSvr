<?php

namespace App\Model;

//use Illuminate\Database\Eloquent\Model;
use App\ViewModel\ProductBindingViewModel;
use App\ViewModel\ProductCriteriaViewModel;
use App\ViewModel\CommonViewModel_tbl_GridListing;
use App\ViewModel\CommonViewModel_tbl_Pager_To_Client;
use Log;

//class ProductModel extends Model
class ProductModel
{    
    // Create
    public function CreateProduct(ProductBindingViewModel $ProductBindingViewModel)
    {
        Log::info("[ProductModel/CreateProduct] Start ........");
        try {
            
            \DB::table('Products')->insert(
                 array(
                        'ProductName'     =>   trim($ProductBindingViewModel->getAttribute('ProductName')), 
                        'Description'     =>   trim($ProductBindingViewModel->getAttribute('Description')),
                        'Price'           =>   trim($ProductBindingViewModel->getAttribute('Price'))
                 )
            );

            /*
            $ProductModel = new ProductModel;
            $ProductModel->ProductName = $ProductBindingViewModel->getAttribute('ProductName');
            $ProductModel->Description = $ProductBindingViewModel->getAttribute('Description');
            $ProductModel->Price = $ProductBindingViewModel->getAttribute('Price');
            $ProductModel->save();
            */
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
            $tbl_GridListing = new CommonViewModel_tbl_GridListing();                        
            $query = \DB::table(\DB::raw('Products, (SELECT @row := 0) RowCounter'));
            $query = $query->select(
                                \DB::raw('@row := @row + 1 AS SrNo'),                                                              
                                'ProductID', 
                                'ProductName', 
                                'Description',
                                'Price',                 
                                 \DB::raw('IFNULL(ProductImage,"") AS ProductImage')
                            );
            
            // where clauses
            if(!$this->IsNullOrEmptyString($ProductCriteriaViewModel->getAttribute('ProductID'))){
                $query = $query->where('ProductID', trim($ProductCriteriaViewModel->getAttribute('ProductID')));
            }

            if(!$this->IsNullOrEmptyString($ProductCriteriaViewModel->getAttribute('ProductName'))){
                $query = $query->where('ProductName', trim($ProductCriteriaViewModel->getAttribute('ProductName')));
            }
            
            if(!$this->IsNullOrEmptyString($ProductCriteriaViewModel->getAttribute('Description'))){
                $query = $query->where('Description', trim($ProductCriteriaViewModel->getAttribute('Description')));
            }

            // orderby clauses
            // ...            
            $OrderByArray = $this->GetOrderByArray(trim($ProductCriteriaViewModel->getAttribute('OrderByClause')));            
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
                            ->take($ProductCriteriaViewModel->getAttribute('RecordPerBatch'))                
                            ->skip(($ProductCriteriaViewModel->getAttribute('BatchIndex') - 1) * $ProductCriteriaViewModel->getAttribute('RecordPerBatch'))
                            ->toSql();
            //Log::info("sqlLog = ".$sqlLog);

            $results =  $query
                            ->take($ProductCriteriaViewModel->getAttribute('RecordPerBatch'))                
                            ->skip(($ProductCriteriaViewModel->getAttribute('BatchIndex') - 1) * $ProductCriteriaViewModel->getAttribute('RecordPerBatch'))
                            ->get();

            $List_ProductBindingViewModel = [];
            foreach ($results as $result) {
                $ProductBindingViewModel = new ProductBindingViewModel();
                $validator = ProductBindingViewModel::validate((array)$result);
                if($validator->fails()){            
                    Log::info("[ProductModel/SelectProductWithoutPager] validator fails message = ".$validator->messages()) ;
                    return $validator->messages();
                }else{
                    $ProductBindingViewModel->fill((array)$result); 
                    $List_ProductBindingViewModel[] = $ProductBindingViewModel;
                }
            }

            $tbl_GridListing->List_Data = $List_ProductBindingViewModel;
            return json_encode((array)$tbl_GridListing);
        }
        catch(Exception $e) {
            Log::error('[ProductModel/SelectProductWithoutPager] Error = '.$e);
        }
    }
    public function SelectProductWithPager(ProductCriteriaViewModel $ProductCriteriaViewModel)
    {
        Log::info("[ProductModel/SelectProductWithPager] Start");
        try {
            $tbl_GridListing = new CommonViewModel_tbl_GridListing();                        
            $query = \DB::table(\DB::raw('Products, (SELECT @row := 0) RowCounter'));
            $query = $query->select(
                                \DB::raw('@row := @row + 1 AS SrNo'),                                                              
                                'ProductID', 
                                'ProductName', 
                                'Description',
                                'Price',                 
                                 \DB::raw('IFNULL(ProductImage,"") AS ProductImage')
                            );
            
            // where clauses
            if(!$this->IsNullOrEmptyString($ProductCriteriaViewModel->getAttribute('ProductID'))){
                $query = $query->where('ProductID', trim($ProductCriteriaViewModel->getAttribute('ProductID')));
            }

            if(!$this->IsNullOrEmptyString($ProductCriteriaViewModel->getAttribute('ProductName'))){
                $query = $query->where('ProductName', trim($ProductCriteriaViewModel->getAttribute('ProductName')));
            }
            
            if(!$this->IsNullOrEmptyString($ProductCriteriaViewModel->getAttribute('Description'))){
                $query = $query->where('Description', trim($ProductCriteriaViewModel->getAttribute('Description')));
            }

            // orderby clauses
            // ...            
            $OrderByArray = $this->GetOrderByArray(trim($ProductCriteriaViewModel->getAttribute('OrderByClause')));            
            foreach($OrderByArray as $rowArray) {
                $query = $query->orderBy($rowArray[0], $rowArray[1]);    
            }

            // count clause
            $TotalRecordCount = $query->count();            
            $tbl_GridListing->TotalRecordCount = $TotalRecordCount;

            // Bind tbl_GridListing
            // ----Bind data to tbl_Pager_To_Client
            //$tbl_GridListing->List_tbl_Pager_To_Client = "";            
            $TotalPage = ceil($TotalRecordCount / $ProductCriteriaViewModel->getAttribute('RecordPerPage'));
            $Pager_BatchIndex = 1;
            $Pager_BehindTheScenseIndex = 1;
            $List_tbl_Pager_To_Client = [];
            for ($i = 1; $i <= $TotalPage; $i++) {

                if($Pager_BehindTheScenseIndex > $ProductCriteriaViewModel->getAttribute('PagerShowIndexOneUpToX')){
                    $Pager_BehindTheScenseIndex = 1;
                }

                $tbl_Pager_To_Client = new CommonViewModel_tbl_Pager_To_Client();
                $tbl_Pager_To_Client->BatchIndex = $Pager_BatchIndex;
                $tbl_Pager_To_Client->DisplayPageIndex = $i;
                $tbl_Pager_To_Client->BehindTheScenesIndex = $Pager_BehindTheScenseIndex;
                $List_tbl_Pager_To_Client[] = $tbl_Pager_To_Client;

                $Pager_BehindTheScenseIndex++;

                if (($i % $ProductCriteriaViewModel->getAttribute('PagerShowIndexOneUpToX')) == 0)
                {
                    $Pager_BatchIndex++;
                }

            }
            $tbl_GridListing->List_tbl_Pager_To_Client = $List_tbl_Pager_To_Client;

            // Bind tbl_GridListing
            // ----Bind data to List_Data
            //$tbl_GridListing->List_Data = "";
            $sqlLog =   $query
                            ->take($ProductCriteriaViewModel->getAttribute('RecordPerBatch'))                
                            ->skip(($ProductCriteriaViewModel->getAttribute('BatchIndex') - 1) * $ProductCriteriaViewModel->getAttribute('RecordPerBatch'))
                            ->toSql();
            //Log::info("sqlLog = ".$sqlLog);

            $results =  $query
                            ->take($ProductCriteriaViewModel->getAttribute('RecordPerBatch'))                
                            ->skip(($ProductCriteriaViewModel->getAttribute('BatchIndex') - 1) * $ProductCriteriaViewModel->getAttribute('RecordPerBatch'))
                            ->get();

            $List_ProductBindingViewModel = [];
            foreach ($results as $result) {
                $ProductBindingViewModel = new ProductBindingViewModel();
                $validator = ProductBindingViewModel::validate((array)$result);
                if($validator->fails()){            
                    Log::info("[ProductModel/SelectProductWithPager] validator fails message = ".$validator->messages()) ;
                    return $validator->messages();
                }else{
                    $ProductBindingViewModel->fill((array)$result); 
                    $List_ProductBindingViewModel[] = $ProductBindingViewModel;
                }
            }

            $tbl_GridListing->List_Data = $List_ProductBindingViewModel;
            return json_encode((array)$tbl_GridListing);
        }
        catch(Exception $e) {
            Log::error('[ProductModel/SelectProductWithPager] Error = '.$e);
        }
    }   
    
    // Update
    // Delete

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
