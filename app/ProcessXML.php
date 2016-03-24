<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use DateTime;
use ArrayObject;
use App\Address;
use App\Category;
use App\Listing;
use App\Mls;
use App\MlsNumber;
use App\Photo;
use App\Status;
use App\Type;

/**
 * This class is used to parse the xml document and load the results into the database.
 *
 */
class ProcessXML extends Model
{
  
  private $listings = array();

    /**
     * Reads the xml document and saves all nodes into an array.
     *
     */
	public function parseXml($xmlFile)
	{
            $listingNumber = -1;
		    $sxml = simplexml_load_file($xmlFile);
            $namespaces = $sxml->getNamespaces(true);
            $this->listings = $sxml->children();
            $this->getCommons($sxml,$namespaces);
	}

    /**
     * Finds the attributes with the commons tag and adds it to the correct listing.
     *
     */
    public function getCommons($sxml,$namespaces)
      {

            foreach($this->listings as $listing)
            {
                $commons = $listing->Address->children($namespaces['commons']);

                foreach($commons as $key=>$value)
                {
                    $listing->addChild($key, $value);
                }
            }
      }

    /**
     * Loads the database with the information provided by the xml document.
     *
     */
    public function loadDatabase()
    {
        foreach($this->listings as $listing)
        {
            $p = $listing->PropertyType;
            $c = $listing->ListingCategory;
            $s = $listing->ListingStatus;

            $propertyType = DB::table('type')->where('PropertyType', $p)->get();
            $listingCategory = DB::table('category')->where('ListingCategory', $c)->get();
            $listingStatus = DB::table('status')->where('ListingStatus', $s)->get();

            $timestamp = new DateTime();
            $timestamp->format('Y-m-d H:i:s');

            if(property_exists($listing, 'DiscloseAddress') && $listing->DiscloseAddress = 'true')
            {
                $listing->DiscloseAddress = 1;
            } 
            else 
            {
                $listing->DiscloseAddress = 0;
            }

            DB::table('listing')->insert(['ListingKey' => $listing->ListingKey,
                                          'ListPrice' => $listing->ListPrice,
                                          'ListingURL' => $listing->ListingURL,
                                          'ListingDescription' => $listing->ListingDescription,
                                          'ListingDate' => $timestamp,
                                          'DiscloseAddress' => $listing->DiscloseAddress,
                                          'Bedrooms' => $listing->Bedrooms,
                                          'Bathrooms' => $listing->Bathrooms,
                                          'MlsNumber' => $listing->MlsNumber,
                                          'MlsId' => $listing->MlsId,
                                          'PropertyType' => $propertyType[0]->id,
                                          'ListingCategory' => $listingCategory[0]->id,
                                          'ListingStatus' => $listingStatus[0]->id]);

            DB::table('address')->insert(['FullStreetAddress' => $listing->FullStreetAddress,
                                          'City' => $listing->City,
                                          'StateOrProvince' => $listing->StateOrProvince,
                                          'PostalCode' => $listing->PostalCode,
                                          'Country' => $listing->Country,
                                          'ListingKey' => $listing->ListingKey]);

            foreach($listing->Photos as $photos)
            {
                foreach($photos as $photo)
                {
                    DB::table('photo')->insert(['MediaModificationTimestamp' => $photo->MediaModificationTimestamp,
                                                'MediaURL' => $photo->MediaURL,
                                                'ListingKey' => $listing->ListingKey]);
                }
            }
        }
    }
}
