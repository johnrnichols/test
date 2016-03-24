<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Populates the database with the minimum amount of information needed to 
 *
 */
class PopulateStatics extends Model
{

	/**
 	 * Checks to see if the database has already been loaded. 
 	 *
 	 */
	public function checkDatabaseStaticValues()
	{
		$loaded = false;

		$catResult = DB::table('category')->get();
		$typeResult = DB::table('type')->get();
		$statResult = DB::table('status')->get();
		$mlsResult = DB::table('mls')->get();

		if($catResult && $typeResult && $statResult && $mlsResult)
		{
			$loaded = true;
		} 
		else 
		{
			PopulateStatics::populateDatabaseStaticValues();
			$loaded = true;
		}

		return $loaded;
	}


	/**
 	 * Loades the category, type, status, and mls tables in the database.
 	 *
 	 */
    public function populateDatabaseStaticValues() {
    	
    	$cat1 = DB::table('category')->insertGetId(['ListingCategory' => 'Purchase']);
    	$cat2 = DB::table('category')->insertGetId(['ListingCategory' => 'Rent']);
    	$cat3 = DB::table('category')->insertGetId(['ListingCategory' => 'Lease']);
    	$cat4 = DB::table('category')->insertGetId(['ListingCategory' => 'Rent to Own']);

    	$type1 = DB::table('type')->insertGetId(['PropertyType' => 'Residential']);
    	$type2 = DB::table('type')->insertGetId(['PropertyType' => 'Commercial']);
    	$type3 = DB::table('type')->insertGetId(['PropertyType' => 'Lots and Land']);

    	$stat1 = DB::table('status')->insertGetId(['ListingStatus' => 'Inactive']);
    	$stat2 = DB::table('status')->insertGetId(['ListingStatus' => 'Active']);

    	$mls1 = DB::table('mls')->insert(['MlsId' => 'BCMLSIA', 'MlsName' => 'Benton County Multiple Listing Service']);
    	$mls2 = DB::table('mls')->insert(['MlsId' => 'BABORNC', 'MlsName' => 'Burlington Alamance Board of Realtors']);
    }
}
