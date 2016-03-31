<?php 

return  [
 
 	'OrderByClause'				=> 'regex:/^([A-Za-z0-9_]+\s(ASC|DESC),?\s?){1,}$/',
 	'SrNo' 						=> 'regex:/^[0-9.]*$/', 	
    'ProductID' 				=> 'regex:/^[0-9.]*$/',
    'ProductName' 				=> 'regex:/^[A-Za-z0-9 ,.\'\"\-\(\)\/]+$/',
    'ProductDescription' 		=> 'regex:/^[A-Za-z0-9 ,.\'\"\-\(\)\/]+$/',    
    'Price'						=> 'regex:/^[0-9.]*$/',    
    'ImagePath'					=> 'regex:/^.*$/'

];