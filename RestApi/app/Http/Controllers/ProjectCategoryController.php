<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Log;

class ProjectCategoryController extends Controller
{
	
	// Retrieve
	public function SelectProjectCategory(Request $request)
	{
		Log::info("[ProjectCategoryController/SelectProjectCategory]");
		return 
		'[{
			"ID": "71A6821F-8D90-42CD-AF12-77BB77B75BA4",
			"Name": "One Account",
			"Description": "One Account",
			"ParentID": "",
			"Sequent": 1
		},
		{
			"ID": "B91CB192-3959-4F4E-B881-8C6E37004FF9",
			"Name": "Savings/Uniplus Account",
			"Description": "Savings/Uniplus Account",
			"ParentID": "",
			"Sequent": 2
		},
		{
			"ID": "3FA5048C-671A-450E-B1AB-884FE0DFAD0D",
			"Name": "Branding Campaign",
			"Description": "Branding Campaign",
			"ParentID": "",
			"Sequent": 3
		},
		{
			"ID": "1A9CB604-0AE3-4C5C-A16F-3DBD2447FAA8",
			"Name": "Press Ad",
			"Description": "Press Ad",
			"ParentID": "B41D0651-066E-46DF-832C-37D63096A47F",
			"Sequent": 2
		},
		{
			"ID": "DA9CB604-0AE3-4C5C-A16F-3DBD2447FAA9",
			"Name": "PA Child",
			"Description": "PA Child",
			"ParentID": "1A9CB604-0AE3-4C5C-A16F-3DBD2447FAA8",
			"Sequent": 2
		},
		{
			"ID": "3FECA7D2-C5B5-4F59-8119-D6C2E60437DA",
			"Name": "TVC",
			"Description": "TVC",
			"ParentID": "B41D0651-066E-46DF-832C-37D63096A47F",
			"Sequent": 2
		},
		{
			"ID": "B41D0651-066E-46DF-832C-37D63096A47F",
			"Name": "ATL Campaigns",
			"Description": "ATL Campaigns",
			"ParentID": "71A6821F-8D90-42CD-AF12-77BB77B75BA4",
			"Sequent": 1
		},
		{
			"ID": "79B74587-D435-4F38-9DCE-9A5F46CCB511",
			"Name": "BTL Campaigns",
			"Description": "BTL Campaigns",
			"ParentID": "71A6821F-8D90-42CD-AF12-77BB77B75BA4",
			"Sequent": 2
		},
		{
			"ID": "B3805919-469A-418A-8525-43418D9D1FB2",
			"Name": "ATL Campaigns",
			"Description": "ATL Campaigns",
			"ParentID": "3FA5048C-671A-450E-B1AB-884FE0DFAD0D",
			"Sequent": 1
		},
		{
			"ID": "2DFCC4DE-EF7A-4713-8BFA-1CE306B55BD5",
			"Name": "ATL Campaigns",
			"Description": "ATL Campaigns",
			"ParentID": "B91CB192-3959-4F4E-B881-8C6E37004FF9",
			"Sequent": 1
		},
		{
			"ID": "5E67EC6F-DEDD-4C30-BCEF-F0D43404FA48",
			"Name": "BTL Campaigns",
			"Description": "BTL Campaigns",
			"ParentID": "B91CB192-3959-4F4E-B881-8C6E37004FF9",
			"Sequent": 2
		}]';
	}
}
