<?php

namespace App;

use DB;
use ArrayObject;
use App\Photo;
use App\Address;
use App\Category;
use App\Mls;
use App\Status;
use App\Type;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $table = 'listing';		// Allows access to the listing table of challengedb
    private $tableListings;				// Holds the std object recieved from database query
    private $outputListings;			// Holds the json string of the final output

    /**
     * Retrieves all listings from the database.
     *
     */
    public function getAllListings()
    {
    	$this->tableListings = DB::table('listing')->get();

    	Listing::fillTheGaps();
    }

    /**
     * Allows the choice of paged data dependant on the view you wish to see.
     *
     */
    public function getPagedListings($operation, $items)
    {
    	if($operation == 'list_price_ascending')
        {
        	$this->tableListings = DB::table('listing')->orderBy('ListPrice','asc')->paginate($items);

        	Listing::fillTheGaps();
        } 
        else if($operation == 'list_price_descending')
        {
            $this->tableListings = DB::table('listing')->orderBy('ListPrice','desc')->paginate($items);

            Listing::fillTheGaps();
        } 
        else if($operation == 'listing_date_ascending')
        {
            $this->tableListings = DB::table('listing')->orderBy('ListingDate','asc')->paginate($items);

            Listing::fillTheGaps();
        } 
        else if($operation == 'listing_date_descending')
        {
            $this->tableListings = DB::table('listing')->orderBy('ListingDate','desc')->paginate($items);
        	
			Listing::fillTheGaps();	
        }
        else if($operation == 'only_pictures')
        {
            $jsonPhoto = DB::table('photo')->paginate($items);
            $this->output = json_encode($jsonPhoto);
        }
        else
        {
            $this->output = 'Unable to process request.';
        }
    }

    /**
     * Allows the status of a ticket to be toggled to inactive or active.
     * 1 = Inactive, 2 = Active
     *
     */
    public function toggleStatus($listingKey, $toggle)
    {
    	$found = false;
    	$values = DB::table('status')->pluck('id');

    	foreach($values as $value)
    	{
    		if($value == $toggle)
    		{
    			$found = true;
    		}
    	}

    	if($found == true)
    	{
    		$this->tableListings = DB::table('listing')->where('ListingKey', $listingKey)->get();
    		$this->tableListings[0]->ListingStatus = $toggle;

    		DB::table('listing')->where('ListingKey', $listingKey)->update(['ListingStatus' => $this->tableListings[0]->ListingStatus]);
    		Listing::fillTheGaps();
    	}
    	else
    	{
    		echo 'An unrecognized value for $toggle has been entered.';
    	}
    	

    }

    /**
     * Fills in the foreign keys of the listing to their corresponding values in their respective tables.
     * 
     */
    public function fillTheGaps()
    {
    	$this->outputListings = new ArrayObject();

    	foreach($this->tableListings as $listing)
    	{
    		if($listing->DiscloseAddress == 1)
    		{
    			$address = DB::table('address')->where('ListingKey', $listing->ListingKey)->get();
    			$listing = (object) array_merge((array) $listing, (array) $address[0]);
    		}

    		$type = DB::table('type')->where('id', $listing->PropertyType)->get();
    		$category = DB::table('category')->where('id', $listing->ListingCategory)->get();
    		$status = DB::table('status')->where('id', $listing->ListingStatus)->get();
    		
    		$listing->PropertyType = $type[0]->PropertyType;
    		$listing->ListingCategory = $category[0]->ListingCategory;
    		$listing->ListingStatus = $status[0]->ListingStatus;

    		$photos = DB::table('photo')->where('ListingKey', $listing->ListingKey)->get();
    		$listing = (object) array_merge((array) $listing, (array) $photos);
    		$this->outputListings->append($listing);
    	}

    	$this->outputListings = json_encode($this->outputListings);
    }

    /**
     * Outputs the final json string of data
     * 
     */
    public function displayResult()
    {
    	echo $this->outputListings;
    }
}
