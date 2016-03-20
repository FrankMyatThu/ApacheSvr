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
		$rules = [
					//'time' => array('regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/')
					'SrNo'     				=> 'sometimes|regex:/^[0-9.]*$/',
					'TotalRecordCount'     	=> 'sometimes|regex:/^[0-9.]*$/',
					'ProductID' 			=> 'sometimes|regex:/^[0-9.]*$/',
					'ProductName'  			=> 'required|regex:/^$/',
					'Description'  			=> 'required',
					'Price'  				=> 'required',
				];
		 $messages = [
						'unique' => 'The :attribute already been registered.',
						'phone.regex' => 'The :attribute number is invalid , accepted format: xxx-xxx-xxxx',
						'address.regex' => 'The :attribute format is invalid.',
					];
				
		Log::info('[ProductViewModel/validate] validate function start');

		foreach ($data as $value) {
		    Log::info('[ProductViewModel/validate/foreachLines] $value ' . $value);
		}
		Log::info('[ProductViewModel/validate] loop end');
		return Validator::make($data, $rules);
	}
}