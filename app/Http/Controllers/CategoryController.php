<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\HomeCategory;
use App\Models\Product;
use App\Models\Language;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
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
            'description' => 'required',
            'banner' => 'mimes:jpeg,jpg,png',
            'icon' => 'mimes:jpeg,jpg,png',
        ]);

		 if ($request->hasfile('banner')) {
            if (!is_dir(public_path() . "/uploads/categories/banner")) {
                mkdir(public_path() .  "/uploads/categories/banner", 0777, true);
            }
			  $banner = str_replace('%', '_', $request->banner->getClientOriginalName());
                $bannerName = "uploads/categories/banner/". $banner;
        } else {
            $bannerName = 'not-found.jpg';
        }
		 if ($request->hasfile('icon')) {
            if (!is_dir(public_path() . "/uploads/categories/icon")) {
                mkdir(public_path() .  "/uploads/categories/icon", 0777, true);
              }
			    $icon = str_replace('%', '_', $request->icon->getClientOriginalName());
                $iconName = "uploads/categories/icon/". $icon;
        } else {
            $iconName = 'not-found.jpg';
        }

        $category = new Category;
        $category->name = $request->name;
        $category->banner = $bannerName;
        $category->icon = $iconName;
        $category->description = $request->description;

        $data = openJSONFile('en');
        $data[$category->name] = $category->name;
        saveJSONFile('en', $data);

      if($category->save()){
		  if ($request->hasfile('icon')) {
			 $request->icon->move(public_path() . '/uploads/categories/icon', $iconName);
		  }
		  if ($request->hasfile('banner')) {
			 $request->banner->move(public_path() . '/uploads/categories/banner', $bannerName);
		  }
            flash(__('Category has been inserted successfully'))->success();
            return redirect()->route('categories.index');
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
        $category = Category::findOrFail(decrypt($id));
        return view('categories.edit', compact('category'));
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
        $category = Category::findOrFail($id);
// dd($request->all());
		$request->validate([
            'name' => 'required',
            'description' => 'required',
            'banner' => 'mimes:jpeg,jpg,png',
            'icon' => 'mimes:jpeg,jpg,png',
        ]);

		if (!$category->banner) {
		   if ($request->hasfile('banner')) {
            if (!is_dir(public_path() . "/uploads/categories/banner")) {
                mkdir(public_path() .  "/uploads/categories/banner", 0777, true);
            }
			   $banner = str_replace('%', '_', $request->banner->getClientOriginalName());
                $bannerName = "uploads/categories/banner/". $banner;
        } else {
            $bannerName = 'not-found.jpg';
        }
	}else{
		 if ($request->hasfile('banner')) {
               $iconPath = (public_path() . '/') . $category->banner;
                if (file_exists($iconPath)) {
                    unlink($iconPath);
                }
               $banner = str_replace('%', '_', $request->banner->getClientOriginalName());
                $bannerName = "uploads/categories/banner/". $banner;

            } else {
                $bannerName = $category->banner;
            }
	}

	if (!$category->icon) {
		   if ($request->hasfile('icon')) {
            if (!is_dir(public_path() . "/uploads/categories/icon")) {
                mkdir(public_path() .  "/uploads/categories/icon", 0777, true);
            }
			$icon = str_replace('%', '_', $request->icon->getClientOriginalName());
                $iconName = "uploads/categories/icon/". $icon;
        } else {
            $iconName = 'not-found.jpg';
        }
	}else{
		 if ($request->hasfile('icon')) {
               $iconPath = (public_path() . '/') . $category->icon;
                if (file_exists($iconPath)) {
                    unlink($iconPath);
                }
               $icon = str_replace('%', '_', $request->icon->getClientOriginalName());
                $iconName = "uploads/categories/icon/". $icon;

            } else {
                $iconName = $category->icon;
            }
	}

        foreach (Language::all() as $key => $language) {
            $data = openJSONFile($language->code);
            unset($data[$category->name]);
            $data[$request->name] = "";
            saveJSONFile($language->code, $data);
        }

        $category->name = $request->name;
        $category->banner = $bannerName;
        $category->head_banner = $bannerName;
        $category->icon = $iconName;
        $category->description = $request->description;


        if($category->save()){
			if ($request->hasfile('icon')) {
			$request->icon->move(public_path() . '/uploads/categories/icon', $iconName);
			}
			if ($request->hasfile('banner')) {
			 $request->banner->move(public_path() . '/uploads/categories/banner', $bannerName);
			}
            flash(__('Category has been updated successfully'))->success();
            return redirect()->route('categories.index');
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
        $category = Category::findOrFail($id);
        foreach ($category->subcategories as $key => $subcategory) {
            foreach ($subcategory->subsubcategories as $key => $subsubcategory) {
                $subsubcategory->delete();
            }
            $subcategory->delete();
        }
        Product::where('category_id', $category->id)->delete();
        HomeCategory::where('category_id', $category->id)->delete();

        if(Category::destroy($id)){
            foreach (Language::all() as $key => $language) {
                $data = openJSONFile($language->code);
                unset($data[$category->name]);
                saveJSONFile($language->code, $data);
            }
			 $iconpath = (public_path() . '/') . $category->icon;
            $imagepathBanner = (public_path() .'/') . $category->banner;
			//dd($imagepath);dd($imagepathBanner);exit;
            if (file_exists($iconpath)) {
                unlink($iconpath);
            }
			if (file_exists($imagepathBanner)) {
                unlink($imagepathBanner);
            }
            flash(__('Category has been deleted successfully'))->success();
            return redirect()->route('categories.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function updateFeatured(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->featured = $request->status;
        if($category->save()){
            return 1;
        }
        return 0;
    }
}
