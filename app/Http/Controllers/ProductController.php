<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Language;
use Auth;
use App\Models\SubSubCategory;
use Session;
use ImageOptimizer;
use Illuminate\Support\Str;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_products(Request $request)
    {
        $type = 'All';

        if ($request->p_name != null) {
            $products = Product::orderBy('created_at', 'desc')->where('name', 'LIKE', '%' . $request->p_name . '%')->paginate();
        } else {
            $products = Product::orderBy('created_at', 'desc')->where('published', 1)->paginate(10);
        }
        //    dd($products);
        return view('products.index', compact('products', 'type'));
    }
    public function admin_products_pending()
    {
        $type = 'All';
        $products = Product::orderBy('created_at', 'desc')->where('published', 0)->get();
        //   dd($products);
        return view('products.pending', compact('products', 'type'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seller_products(Request $request)
    {
        $data = $request->all();
        $type = 'Seller';
        $sellers = User::where('user_type', 'seller')->get();

        if (!empty($data)) {
            $products = Product::where('added_by', 'seller')->where('user_id', $request->seller_id)->orderBy('created_at', 'desc')->get();
        } else {
            $products = Product::where('added_by', 'seller')->orderBy('created_at', 'desc')->get();
        }


        return view('products.index', compact('products', 'type', 'sellers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $product = new Product;
        $product->name = $request->name;
        $product->added_by = $request->added_by;
        $product->user_id = Auth::user()->id;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->subsubcategory_id = $request->subsubcategory_id;
        $product->brand_id = $request->brand_id;

        $photos = array();

       if ($request->hasFile('photos')) {
    $photos = [];

    foreach ($request->photos as $photo) {
        // Original image store
        $path = $photo->store('uploads/products/photos');
        $fullPath = public_path($path);

        // Optimize original
        ImageOptimizer::optimize($fullPath);

        // Convert to WebP (overwrite photos array with webp path)
        $webpName = pathinfo($path, PATHINFO_FILENAME) . '.webp';
        $webpPath = 'uploads/products/photos/' . $webpName; // same folder
        $fullWebpPath = public_path($webpPath);

        if (convertToWebP($fullPath, $fullWebpPath, 90)) {
            $photos[] = $webpPath;
            // Delete original file after converting to webp
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }

    // Save only webp paths
    $product->photos = json_encode($photos);
}

      if ($request->hasFile('thumbnail_img')) {
    // Generate slug-based filename without extension
    $slug = \Str::slug($request->name);
    $filename = $slug . '.webp';

    // Define folders
    $mainFolder = 'uploads/products/thumbnail';
    $webpFolder = 'uploads/products/thumbnail/webp';

    // Make sure folders exist
    if (!File::exists(public_path($mainFolder))) {
        File::makeDirectory(public_path($mainFolder), 0755, true);
    }
    if (!File::exists(public_path($webpFolder))) {
        File::makeDirectory(public_path($webpFolder), 0755, true);
    }

    // Temporary original upload (before conversion)
    $tempPath = $mainFolder . '/' . $slug . '.' . $request->thumbnail_img->getClientOriginalExtension();
    $request->thumbnail_img->move(public_path($mainFolder), basename($tempPath));

    // Optimize original
    ImageOptimizer::optimize(public_path($tempPath));

    // Convert to WebP in main folder
    $mainWebpPath = $mainFolder . '/' . $filename;
    convertToWebP(public_path($tempPath), public_path($mainWebpPath));

    // Convert to WebP in webp folder
    $webpPath = $webpFolder . '/' . $filename;
    convertToWebP(public_path($tempPath), public_path($webpPath));

    // Remove the temporary original non-webp file
    if (File::exists(public_path($tempPath))) {
        File::delete(public_path($tempPath));
    }

    // Save in DB (both in webp format)
    $product->thumbnail_img = $mainWebpPath;
    $product->thumbnail_webp = $webpPath;
}

      if ($request->hasFile('featured_img')) {
    // Original file store
    $path = $request->featured_img->store('uploads/products/featured');
    $fullPath = public_path($path);

    // Optimize original
    ImageOptimizer::optimize($fullPath);

    // Convert to WebP
    $webpName = pathinfo($path, PATHINFO_FILENAME) . '.webp';
    $webpPath = 'uploads/products/featured/' . $webpName;
    $fullWebpPath = public_path($webpPath);

    if (convertToWebP($fullPath, $fullWebpPath, 90)) {
        // Delete original after converting to webp
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
        // Save only webp path
        $product->featured_img = $webpPath;
    }
}

      if ($request->hasFile('flash_deal_img')) {
    // Store original file
    $path = $request->flash_deal_img->store('uploads/products/flash_deal');
    $fullPath = public_path($path);

    // Optimize original file
    ImageOptimizer::optimize($fullPath);

    // Convert to WebP
    $webpName = pathinfo($path, PATHINFO_FILENAME) . '.webp';
    $webpPath = 'uploads/products/flash_deal/' . $webpName;
    $fullWebpPath = public_path($webpPath);

    if (convertToWebP($fullPath, $fullWebpPath, 90)) {
        // Delete original file after converting
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
        // Save webp file path
        $product->flash_deal_img = $webpPath;
    }
}

        $product->unit = $request->unit;
        $product->prescribed = $request->prescribed;
        $product->tags = implode('|', $request->tags);
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->video_provider = $request->video_provider;
        $product->video_link = $request->video_link;
        $product->unit_price = $request->unit_price;
        $product->purchase_price = $request->purchase_price;
        $product->tax = $request->tax;
        $product->tax_type = $request->tax_type;
        $product->discount = $request->discount;
        $product->discount_type = $request->discount_type;
        $product->shipping_type = $request->shipping_type;
        if ($request->shipping_type == 'free') {
            $product->shipping_cost = 0;
        } elseif ($request->shipping_type == 'local_pickup') {
            $product->shipping_cost = $request->local_pickup_shipping_cost;
        } elseif ($request->shipping_type == 'flat_rate') {
            $product->shipping_cost = $request->flat_shipping_cost;
        }
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;

       if ($request->hasFile('meta_img')) {
    // Store original
    $path = $request->meta_img->store('uploads/products/meta');
    $fullPath = public_path($path);

    // Optimize original
    ImageOptimizer::optimize($fullPath);

    // Convert to WebP
    $webpName = pathinfo($path, PATHINFO_FILENAME) . '.webp';
    $webpPath = 'uploads/products/meta/' . $webpName;
    $fullWebpPath = public_path($webpPath);

    if (convertToWebP($fullPath, $fullWebpPath, 90)) {
        // Delete original file after converting
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
        // Save WebP path in DB
        $product->meta_img = $webpPath;
    }
}

        $random = Str::random(5);
        $product->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->slug)));

        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $product->colors = json_encode($request->colors);
        } else {
            $colors = array();
            $product->colors = json_encode($colors);
        }

        $choice_options = array();

        if ($request->has('choice')) {
            foreach ($request->choice_no as $key => $no) {
                $str = 'choice_options_' . $no;
                $item['name'] = 'choice_' . $no;
                $item['title'] = $request->choice[$key];
                $item['options'] = explode(',', implode('|', $request[$str]));
                array_push($choice_options, $item);
            }
        }

        $product->choice_options = json_encode($choice_options);

        $variations = array();

        //combinations start
        $options = array();
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        }

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }

        //Generates the combinations of customer choice options
        $combinations = combinations($options);
        if (count($combinations[0]) > 0) {
            foreach ($combinations as $key => $combination) {
                $str = '';
                foreach ($combination as $key => $item) {
                    if ($key > 0) {
                        $str .= '-' . str_replace(' ', '', $item);
                    } else {
                        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
                            $color_name = \App\Models\Color::where('code', $item)->first()->name;
                            $str .= $color_name;
                        } else {
                            $str .= str_replace(' ', '', $item);
                        }
                    }
                }
                $item = array();
                $item['price'] = $request['price_' . str_replace('.', '_', $str)];
                $item['sku'] = $request['sku_' . str_replace('.', '_', $str)];
                $item['qty'] = $request['qty_' . str_replace('.', '_', $str)];
                $variations[$str] = $item;
            }
        }
        //combinations end

        $product->variations = json_encode($variations);

        $data = openJSONFile('en');
        $data[$product->name] = $product->name;
        saveJSONFile('en', $data);

        if ($product->save()) {
            flash(__('Product has been inserted successfully'))->success();
            if (Auth::user()->user_type == 'admin') {
                return redirect()->route('products.admin');
            } else {
                return redirect()->route('seller.products');
            }
        } else {
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
    public function admin_product_edit($id)
    {
        $product = Product::findOrFail(decrypt($id));
        //dd(json_decode($product->price_variations)->choices_0_S_price);
        $tags = json_decode($product->tags);
        $categories = Category::all();
        $brands = Brand::all();
        return view('products.edit', compact('product', 'categories', 'tags', 'brands'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function seller_product_edit($id)
    {
        $product = Product::findOrFail(decrypt($id));
        //dd(json_decode($product->price_variations)->choices_0_S_price);
        $tags = json_decode($product->tags);
        $categories = Category::all();
        $brands = Brand::all();
        return view('products.edit', compact('product', 'categories', 'tags', 'brands'));
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
    $product = Product::findOrFail($id);

    $product->name = $request->name;
    $product->category_id = $request->category_id;
    $product->subcategory_id = $request->subcategory_id;
    $product->subsubcategory_id = $request->subsubcategory_id;
    $product->brand_id = $request->brand_id;
    $product->unit = $request->unit;
    $product->prescribed = $request->prescribed;
    $product->tags = implode('|', $request->tags);
    $product->description = $request->description;
    $product->short_description = $request->short_description;
    $product->video_provider = $request->video_provider;
    $product->video_link = $request->video_link;
    $product->unit_price = $request->unit_price;
    $product->purchase_price = $request->purchase_price;
    $product->tax = $request->tax;
    $product->tax_type = $request->tax_type;
    $product->discount = $request->discount;
    $product->discount_type = $request->discount_type;
    $product->shipping_type = $request->shipping_type;

    if ($request->shipping_type == 'free') $product->shipping_cost = 0;
    elseif ($request->shipping_type == 'local_pickup') $product->shipping_cost = $request->local_pickup_shipping_cost;
    elseif ($request->shipping_type == 'flat_rate') $product->shipping_cost = $request->flat_shipping_cost;

    $product->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->slug)));

    // Handle photos
    // Handle photos update
$photos = $request->previous_photos ?? [];

if ($request->hasFile('photos')) {
    foreach ($request->photos as $photo) {
        // Original image store temporarily
        $tempPath = $photo->store('uploads/products/photos/temp');
        $fullTempPath = public_path($tempPath);

        // Optimize temp
        ImageOptimizer::optimize($fullTempPath);

        // WebP path
        $slugName = Str::slug(pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME));
        $photoFolder = 'uploads/products/photos';
        if (!File::exists(public_path($photoFolder))) File::makeDirectory(public_path($photoFolder), 0755, true);

        $webpPath = $photoFolder . '/' . $slugName . '.webp';
        $fullWebpPath = public_path($webpPath);

        if (convertToWebP($fullTempPath, $fullWebpPath, 90)) {
            $photos[] = $webpPath;

            // Delete temp original
            if (file_exists($fullTempPath)) unlink($fullTempPath);
        }
    }
}

$product->photos = json_encode($photos);

    // Thumbnail image
    
    if ($request->hasFile('thumbnail_img')) {
    $slugName = Str::slug($request->name);

    $thumbFolder = public_path('uploads/products/thumbnail');
    $webpFolder = $thumbFolder . '/webp';

    if (!File::exists($thumbFolder)) File::makeDirectory($thumbFolder, 0755, true);
    if (!File::exists($webpFolder)) File::makeDirectory($webpFolder, 0755, true);

    $file = $request->file('thumbnail_img');  // UploadedFile
    $ext = $file->getClientOriginalExtension();
    $thumbnailFileName = $slugName . '.' . $ext;
    $thumbnailFullPath = $thumbFolder . '/' . $thumbnailFileName;

    // Move uploaded file to thumbnail folder
    $file->move($thumbFolder, $thumbnailFileName);

    // WebP path
    $thumbnailWebpPath = $webpFolder . '/' . $slugName . '.webp';

    // Convert to WebP using real path
    convertToWebP($thumbnailFullPath, $thumbnailWebpPath);

    // Optimize both
    ImageOptimizer::optimize($thumbnailFullPath);
    ImageOptimizer::optimize($thumbnailWebpPath);

    // Save relative paths to DB
    $product->thumbnail_img = 'uploads/products/thumbnail/' . $thumbnailFileName;
    $product->thumbnail_webp = 'uploads/products/thumbnail/webp/' . $slugName . '.webp';
} else {
    $product->thumbnail_img = $request->previous_thumbnail_img;
    $product->thumbnail_webp = $request->previous_thumbnail_webp ?? null;
}

    // Featured image
 $product->featured_img = $request->previous_featured_img ?? null;

if ($request->hasFile('featured_img')) {
    $slugName = Str::slug($request->name);

    $featFolder = public_path('uploads/products/featured');
    $webpFolder = $featFolder . '/webp';

    if (!File::exists($featFolder)) File::makeDirectory($featFolder, 0755, true);
    if (!File::exists($webpFolder)) File::makeDirectory($webpFolder, 0755, true);

    $file = $request->file('featured_img');
    $ext = $file->getClientOriginalExtension();
    $featuredFileName = $slugName . '.' . $ext;
    $featuredFullPath = $featFolder . '/' . $featuredFileName;

    // Move uploaded file
    $file->move($featFolder, $featuredFileName);

    // WebP path
    $featuredWebpPath = $webpFolder . '/' . $slugName . '.webp';

    // Convert to WebP
    convertToWebP($featuredFullPath, $featuredWebpPath);

    // Optimize
    ImageOptimizer::optimize($featuredFullPath);
    ImageOptimizer::optimize($featuredWebpPath);

    // Save relative path to DB
    $product->featured_img = 'uploads/products/featured/' . $featuredFileName;
}

   // Flash Deal Image
$product->flash_deal_img = $request->previous_flash_deal_img ?? null;

if ($request->hasFile('flash_deal_img')) {
    $slugName = Str::slug($request->name);

    $flashFolder = public_path('uploads/products/flash_deal');
    $webpFolder = $flashFolder . '/webp';

    // Create folders if not exist
    if (!File::exists($flashFolder)) File::makeDirectory($flashFolder, 0755, true);
    if (!File::exists($webpFolder)) File::makeDirectory($webpFolder, 0755, true);

    $file = $request->file('flash_deal_img');
    $ext = $file->getClientOriginalExtension();
    $flashFileName = $slugName . '.' . $ext;
    $flashFullPath = $flashFolder . '/' . $flashFileName;

    // Move uploaded file
    $file->move($flashFolder, $flashFileName);

    // WebP path
    $flashWebpPath = $webpFolder . '/' . $slugName . '.webp';

    // Convert to WebP
    convertToWebP($flashFullPath, $flashWebpPath);

    // Optimize images
    ImageOptimizer::optimize($flashFullPath);
    ImageOptimizer::optimize($flashWebpPath);

    // Save relative path in DB
    $product->flash_deal_img = 'uploads/products/flash_deal/' . $flashFileName;
}

   // Meta Image
$product->meta_img = $request->previous_meta_img ?? null;

if ($request->hasFile('meta_img')) {
    $slugName = Str::slug($request->name);

    $metaFolder = public_path('uploads/products/meta');
    $webpFolder = $metaFolder . '/webp';

    // Create folders if not exist
    if (!File::exists($metaFolder)) File::makeDirectory($metaFolder, 0755, true);
    if (!File::exists($webpFolder)) File::makeDirectory($webpFolder, 0755, true);

    $file = $request->file('meta_img');
    $ext = $file->getClientOriginalExtension();
    $metaFileName = $slugName . '.' . $ext;
    $metaFullPath = $metaFolder . '/' . $metaFileName;

    // Move uploaded file
    $file->move($metaFolder, $metaFileName);

    // WebP path
    $metaWebpPath = $webpFolder . '/' . $slugName . '.webp';

    // Convert to WebP
    convertToWebP($metaFullPath, $metaWebpPath);

    // Optimize images
    ImageOptimizer::optimize($metaFullPath);
    ImageOptimizer::optimize($metaWebpPath);

    // Save relative path in DB
    $product->meta_img = 'uploads/products/meta/' . $metaFileName;
}

    // Colors, choices, variations (same logic as before)
    $product->colors = ($request->has('colors_active') && count($request->colors) > 0) ? json_encode($request->colors) : json_encode([]);
    $choice_options = [];
    if ($request->has('choice')) {
        foreach ($request->choice_no as $key => $no) {
            $str = 'choice_options_' . $no;
            $item['name'] = 'choice_' . $no;
            $item['title'] = $request->choice[$key];
            $item['options'] = explode(',', implode('|', $request[$str]));
            $choice_options[] = $item;
        }
    }
    $product->choice_options = json_encode($choice_options);

    // Variations logic (unchanged)
    $variations = [];
    $options = [];
    if ($request->has('colors_active') && count($request->colors) > 0) $options[] = $request->colors;
    if ($request->has('choice_no')) {
        foreach ($request->choice_no as $key => $no) {
            $name = 'choice_options_' . $no;
            $options[] = explode(',', implode('|', $request[$name]));
        }
    }
    $combinations = combinations($options);
    if (count($combinations[0]) > 0) {
        foreach ($combinations as $combination) {
            $str = '';
            foreach ($combination as $key => $item) {
                $str .= ($key > 0 ? '-' : '') . str_replace(' ', '', $item);
            }
            $variations[$str] = [
                'price' => $request['price_' . str_replace('.', '_', $str)],
                'sku'   => $request['sku_' . str_replace('.', '_', $str)],
                'qty'   => $request['qty_' . str_replace('.', '_', $str)],
            ];
        }
    }
    $product->variations = json_encode($variations);

    // Save
    if ($product->save()) {
        flash(__('Product has been updated successfully'))->success();
        return Auth::user()->user_type == 'admin'
            ? redirect()->route('products.admin')
            : redirect()->route('seller.products');
    } else {
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
        $product = Product::findOrFail($id);
        if (Product::destroy($id)) {
            foreach (Language::all() as $key => $language) {
                $data = openJSONFile($language->code);
                unset($data[$product->name]);
                saveJSONFile($language->code, $data);
            }
            if ($product->thumbnail_img != null) {
                //unlink($product->thumbnail_img);
            }
            if ($product->featured_img != null) {
                //unlink($product->featured_img);
            }
            if ($product->flash_deal_img != null) {
                //unlink($product->flash_deal_img);
            }
            foreach (json_decode($product->photos) as $key => $photo) {
                //unlink($photo);
            }
            flash(__('Product has been deleted successfully'))->success();
            if (Auth::user()->user_type == 'admin') {
                return redirect()->route('products.admin');
            } else {
                return redirect()->route('seller.products');
            }
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Duplicates the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate($id)
    {
        $product = Product::find($id);
        $product_new = $product->replicate();
        $product_new->slug = substr($product_new->slug, 0, -5) . str_random(5);

        if ($product_new->save()) {
            flash(__('Product has been duplicated successfully'))->success();
            if (Auth::user()->user_type == 'admin') {
                return redirect()->route('products.admin');
            } else {
                return redirect()->route('seller.products');
            }
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function get_products_by_subsubcategory(Request $request)
    {
        $products = Product::where('subsubcategory_id', $request->subsubcategory_id)->get();
        return $products;
    }

    public function get_products_by_brand(Request $request)
    {
        $products = Product::where('brand_id', $request->brand_id)->get();
        return view('partials.product_select', compact('products'));
    }

    public function updateTodaysDeal(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->todays_deal = $request->status;
        if ($product->save()) {
            return 1;
        }
        return 0;
    }

    public function updatePublished(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->published = $request->status;
        if ($product->save()) {
            return 1;
        }
        return 0;
    }

    public function updateFeatured(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->featured = $request->status;
        if ($product->save()) {
            return 1;
        }
        return 0;
    }

    public function isStock(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->is_stock = $request->status;
        if ($product->save()) {
            return 1;
        }
        return 0;
    }

    public function sku_combination(Request $request)
    {
        $options = array();
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        } else {
            $colors_active = 0;
        }

        $unit_price = $request->unit_price;
        $product_name = $request->name;

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }

        $combinations = combinations($options);
        return view('partials.sku_combinations', compact('combinations', 'unit_price', 'colors_active', 'product_name'));
    }

    public function sku_combination_edit(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $options = array();
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        } else {
            $colors_active = 0;
        }

        $product_name = $request->name;
        $unit_price = $request->unit_price;

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }

        $combinations = combinations($options);
        return view('partials.sku_combinations_edit', compact('combinations', 'unit_price', 'colors_active', 'product_name', 'product'));
    }
}
