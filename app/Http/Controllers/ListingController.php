<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Listing;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listings = Listing::all();
        echo $listings;
    }

    /**
     * Retrieves all listings from the database.
     *
     */
    public function getListings()
    {
        $page = new Listing();
        $page->getAllListings();
        $page->displayResult();
    }

    /**
     * Allows the choice of paged data dependant on the view you wish to see.
     *
     */
    public function pagedData($operation, $items)
    {
        $page = new Listing();
        $page->getPagedListings($operation, $items);
        $page->displayResult();
    }

    /**
     * Allows the status of a ticket to be toggled to inactive or active.
     * 1 = Inactive, 2 = Active
     *
     */
    public function toggleStatus($listingKey, $toggle)
    {
        $page = new Listing();
        $page->toggleStatus($listingKey, $toggle);
        $page->displayResult();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$listing = new Listing();
       	
        foreach($request as $key=>$value)
        {
        	$listing->$key = $value;
        }
        
        $listing->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
