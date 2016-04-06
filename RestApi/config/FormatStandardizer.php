<?php 

return  [
 
 	'OrderByClause'				=> 'regex:/^([A-Za-z0-9_]+\s(ASC|DESC),?\s?){1,}$/',
 	'SrNo' 						=> 'regex:/^[0-9.]*$/', 	
 	'ID'						=> 'regex:/^[0-9.]*$/',
 	'Name'						=> 'regex:/^[A-Za-z0-9.\s]+$/',
 	'Description'				=> 'regex:/^[A-Za-z0-9.\s]+$/',
 	'Numeric'					=> 'regex:/^[0-9.]*$/',
    
    'ProductID' 				=> 'regex:/^[0-9.]*$/',
    'ProductName' 		        => 'regex:/^[A-Za-z0-9.\s;,]+$/',
    'ProductDescription' 		=> 'regex:/^[A-Za-z0-9.\s;,]+$/',  
    
    'Price'						=> 'regex:/^[0-9.]*$/',    
    'ImagePath'					=> 'regex:/^.*$/'

];