<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\FeatureBrand;
use Illuminate\Http\Request;

class FeatureBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feature_brand = FeatureBrand::orderBy('created_at','desc')->get();
        return view('feature_brand.index',compact('feature_brand'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();
        return view('feature_brand.create',compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $feature_brand = new FeatureBrand();
        $feature_brand->title = $request->title;
        $feature_brand->description = $request->description;
        $feature_brand->brand_id = $request->brand_id;

        if($request->hasFile('image')){
            $feature_brand->image = $request->file('image')->store('uploads/feature_brand');
        }

        if($feature_brand->save()){
            flash(__('Feature Brand has been inserted successfully'))->success();
            return redirect()->route('feature-brands.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
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
        $feature_brand = FeatureBrand::findOrFail(decrypt($id));
        $brands = Brand::all();
        return view('feature_brand.edit', compact('feature_brand','brands'));
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
        $feature_brand = FeatureBrand::findOrFail($id);
        $feature_brand->title = $request->title;
        $feature_brand->description = $request->description;
        $feature_brand->brand_id = $request->brand_id;

        if($request->hasFile('image')){
            $feature_brand->image = $request->file('image')->store('uploads/feature_brand');
        }

        if($feature_brand->save()){
            flash(__('Feature Brand has been Updated successfully'))->success();
            return redirect()->route('feature-brands.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(FeatureBrand::destroy($id)){

            flash(__('Feature Brand has been deleted successfully'))->success();
            return redirect()->route('feature-brands.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }
}
