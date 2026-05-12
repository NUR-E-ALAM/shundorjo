<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        return view('brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

		  $request->validate([
            'name' => 'required',
            'logo' => 'mimes:jpeg,jpg,png',
            'banner' => 'mimes:jpeg,jpg,png',
            'featured' => 'required',
        ]);

		    if ($request->hasfile('logo')) {
            if (!is_dir(public_path() . "/uploads/brands/")) {
                mkdir(public_path() .  "/uploads/brands/", 0777, true);
            }
			 $logo = str_replace('%', '_', $request->logo->getClientOriginalName());
                $logoName = "uploads/brands/".str_replace(' ', '_', $request->name) . '_' . $logo;
        } else {
            $logoName = 'not-found.jpg';
        }
		  if ($request->hasfile('banner')) {
            if (!is_dir(public_path() . "/uploads/brands/")) {
                mkdir(public_path() .  "/uploads/brands/", 0777, true);
            }
				$banner = str_replace('%', '_', $request->banner->getClientOriginalName());
                $bannerName = "uploads/brands/".str_replace(' ', '_', $request->name) . '_' . $banner;
        } else {
            $bannerName = 'not-found.jpg';
        }
        $brand = new Brand;
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->logo = $logoName;
        $brand->banner = $bannerName;
        $brand->featured = $request->featured;

        if($brand->save()){
			if ($request->hasfile('logo')) {
			 $request->logo->move(public_path() . '/uploads/brands/', $logoName);
			}
			 if ($request->hasfile('banner')) {
			 $request->banner->move(public_path() . '/uploads/brands/', $bannerName);
			 }
            flash(__('Brand has been inserted successfully'))->success();
            return redirect()->route('brands.index');
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
        $brand = Brand::findOrFail(decrypt($id));
        return view('brands.edit', compact('brand'));
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
        $brand = Brand::findOrFail($id);


         $request->validate([
            'name' => 'required',
            'logo' => 'mimes:jpeg,jpg,png',
            'banner' => 'mimes:jpeg,jpg,png',
            'featured' => 'required',
        ]);
		if (!$brand->logo) {
		    if ($request->hasfile('logo')) {
            if (!is_dir(public_path() . "/uploads/brands/")) {
                mkdir(public_path() .  "/uploads/brands/", 0777, true);
            }
			  $logo = str_replace('%', '_', $request->logo->getClientOriginalName());
                $logoName = "uploads/brands/".str_replace(' ', '_', $request->name) . '_' . $logo;

        } else {
            $logoName = 'not-found.jpg';
        }
	}else{
		 if ($request->hasfile('logo')) {
               $logoPath = (public_path() . '/') . $brand->logo;
                if (file_exists($logoPath)) {
                    unlink($logoPath);
                }
                $logo = str_replace('%', '_', $request->logo->getClientOriginalName());
                $logoName = "uploads/brands/".str_replace(' ', '_', $request->name) . '_' . $logo;
            } else {
                $logoName = $brand->logo;
            }
	}
	if (!$brand->banner) {
		  if ($request->hasfile('banner')) {
            if (!is_dir(public_path() . "/uploads/brands/")) {
                mkdir(public_path() .  "/uploads/brands/", 0777, true);
                  }
				   $banner = str_replace('%', '_', $request->banner->getClientOriginalName());
                $bannerName = "uploads/brands/".str_replace(' ', '_', $request->name) . '_' . $banner;
        } else {
            $bannerName = 'not-found.jpg';
        }
	}
	else{
		 if ($request->hasfile('banner')) {
               $bannerPath = (public_path() . '/') . $brand->banner;
                if (file_exists($bannerPath)) {
                    unlink($bannerPath);
                }
                $banner = str_replace('%', '_', $request->banner->getClientOriginalName());
                $bannerName = "uploads/brands/".str_replace(' ', '_', $request->name) . '_' . $banner;
            } else {
                $bannerName = $brand->banner;
            }

	}

		$brand->name = $request->name;
        $brand->description = $request->description;
		$brand->logo = $logoName;
        $brand->banner = $bannerName;
        $brand->featured = $request->featured;

        if($brand->save()){
			if ($request->hasfile('logo')) {
			$request->logo->move(public_path() . '/uploads/brands/', $logoName);
			}
			if ($request->hasfile('banner')) {
			 $request->banner->move(public_path() . '/uploads/brands/', $bannerName);
			}
            flash(__('Brand has been updated successfully'))->success();
            return redirect()->route('brands.index');
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
        $brand = Brand::findOrFail($id);
        Product::where('brand_id', $brand->id)->delete();
        if(Brand::destroy($id)){
           /*  if($brand->logo != null){
                //unlink($brand->logo);
            } */
			 $imagepath = (public_path() . '/') . $brand->logo;
            $imagepathBanner = (public_path() .'/') . $brand->banner;
			//dd($imagepath);dd($imagepathBanner);exit;
            if (file_exists($imagepath)) {
                unlink($imagepath);
            }
			if (file_exists($imagepathBanner)) {
                unlink($imagepathBanner);
            }
            flash(__('Brand has been deleted successfully'))->success();
            return redirect()->route('brands.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }
}
