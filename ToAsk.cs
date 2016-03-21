Below is my view model class in c#.

    public class ProductViewModel
    {
    	[Display(Name = "Srno")]
    	[RegularExpression(FormatStandardizer.Server_Numeric, ErrorMessage = "Invalid {0}")]
    	public int? SrNo { get; set; }
    
    	[Display(Name = "TotalRecordCount")]
    	[RegularExpression(FormatStandardizer.Server_Numeric, ErrorMessage = "Invalid {0}")]
    	public int? TotalRecordCount { get; set; }
    
    	[Display(Name = "Product Id")]
    	[RegularExpression(FormatStandardizer.Server_Numeric, ErrorMessage = "Invalid {0}")]
    	public int? ProductID { get; set; }
    	
    	[Display(Name = "Product name")]
    	[Required(ErrorMessage = "{0} is required.")]
    	[StringLength(250, MinimumLength = 1, ErrorMessage = "{0}'s length should be between {2} and {1}.")]
    	[RegularExpression(FormatStandardizer.Server_Name_MultiWord, ErrorMessage = "Invalid {0}")]
    	public string ProductName { get; set; }
    
    	[Display(Name = "Description")]
    	[Required(ErrorMessage = "{0} is required.")]
    	[StringLength(250, MinimumLength = 1, ErrorMessage = "{0}'s length should be between {2} and {1}.")]
    	[RegularExpression(FormatStandardizer.Server_Name_MultiWord, ErrorMessage = "Invalid {0}")]
    	public string Description { get; set; }
    
    	[Display(Name = "Price")]
    	[Required(ErrorMessage = "{0} is required.")]        
    	[RegularExpression(FormatStandardizer.Server_Numeric, ErrorMessage = "Invalid {0}")]
    	public decimal Price { get; set; }	
    }

I want to do the same class in PHP laravel.
Below is php view model class which i created.

    class ProductViewModel extends Model
    {
        public $SrNo;
    	public $TotalRecordCount;
    	public $ProductID;
    	public $ProductName;
    	public $Description;
    	public $Price;
    	
    	protected function validate($data){		
    		$rules = array(
    					'SrNo'     				=> 'sometimes|regex:/^[0-9.]*$/',
    					'TotalRecordCount'     	=> 'sometimes|regex:/^[0-9.]*$/',
    					'ProductID' 			=> 'sometimes|regex:/^[0-9.]*$/',
    					'ProductName'  			=> 'required|regex:/^[A-Za-z0-9 ,.\'-]+$/|min:1|max:250',
    					'Description'  			=> 'required|regex:/^[A-Za-z0-9 ,.\'-]+$/|min:1|max:250',
    					'Price'  				=> 'required|regex:/^[0-9.]*$/'
    				);	
    		$messages = array(
    					'SrNo.regex' 				=> 'Invalid SrNo.',
    					'TotalRecordCount.regex'	=> 'Invalid TotalRecordCount.'
    					'ProductID.regex' 			=> 'Invalid ProductID.',
    					'ProductName.required' 		=> 'Product Name is required.',
    					'ProductName.regex'			=> 'Invalid Product Name.'
    					'ProductName.min'			=> 'Product Name\'s length should be between 1 and 250.',
    					'ProductName.max'			=> 'Product Name\'s length should be between 1 and 250.',
    					'Description.required' 		=> 'Description is required.',
    					'Description.regex'			=> 'Invalid Description.'
    					'Description.min'			=> 'Description\'s length should be between 1 and 250.',
    					'Description.max'			=> 'Description\'s length should be between 1 and 250.',
    					'Price.required'			=> 'Price is required',
    					'Price.regex'   			=> 'Invalid Price',
    				);
    				
    		Log::info('[ProductViewModel/validate] validate function start');
    		foreach ($data as $value) {
    		    Log::info('[ProductViewModel/validate/foreachLines] $value ' . $value);
    		}
    		Log::info('[ProductViewModel/validate] loop end');
    		
    		return Validator::make($data, $rules, $messages);
    	}
    }
	
Please give me suggestion how could I make it better.


[
	{
		"ProductName" : "Dell Inspiron 14 Laptop, 14 inch HD (1366 x 768) LED-Backlit", 
		"Description" : "Display, Celeron Processor N3050 up to 2.16 GHz, 2GB DDR3 RAM, 32GB eMMC, No DVD/CD Drive, Windows 10 Home (Certified Refurbished)",
		"Price" : "239.00"
	}
	,
	{
		"ProductName" : "HP 15-F211WM 15.6-Inch Touchscreen Laptop", 
		"Description" : "HP 15-F211WM 15.6-Inch Touchscreen Laptop (Intel Celeron N2840, Dual Core, 4GB, 500GB HDD, DVD-RW, WIFI, HDMI, Windows 10)",
		"Price" : "325.00"
	}
]