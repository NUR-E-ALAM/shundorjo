<?php

namespace App\Http\Controllers;

use App\Models\SpecialOffer;
use Illuminate\Http\Request;

class SpecialOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = SpecialOffer::all();
        return view("offer.index", compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('offer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $link = new SpecialOffer;
        $link->title = $request->title;
        $link->tamount = $request->tamount;
        $link->upto = $request->upto;
        $link->uamount = $request->uamount;
        $link->status = "1";
        if($link->save()){
            flash('Special Offer has been inserted successfully')->success();
            return redirect()->route('special-offer.index');
        }
        flash('Something went wrong')->error();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SpecialOffer  $specialOffer
     * @return \Illuminate\Http\Response
     */
    public function show(SpecialOffer $specialOffer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SpecialOffer  $specialOffer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $link = SpecialOffer::findOrFail(decrypt($id));
        return view('offer.edit', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SpecialOffer  $specialOffer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $link = SpecialOffer::findOrFail($id);
        $link->title = $request->title;
        $link->tamount = $request->tamount;
        $link->upto = $request->upto;
        $link->uamount = $request->uamount;
        if($link->save()){
            flash('Special Offer has been updated successfully')->success();
            return redirect()->route('special-offer.index');
        }
        flash('Something went wrong')->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SpecialOffer  $specialOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $link = SpecialOffer::findOrFail($id);
        if(SpecialOffer::destroy($id)){
            flash('Special Offer has been deleted successfully')->success();
            return redirect()->route('special-offer.index');
        }

        flash('Something went wrong')->error();
        return back();
    }

    public function updateFeatured(Request $request)
    {
        $category = SpecialOffer::findOrFail($request->id);
        $category->status = $request->status;
        if($category->save()){
            return 1;
        }
        return 0;
    }
}
