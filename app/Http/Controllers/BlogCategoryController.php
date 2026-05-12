<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\Category;
use DataTables;
use App\Http\Controllers\Controller;
use Validator;
use ImageOptimizer;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{


     //*** GET Request

     public function index()
     {
        //  dd(BlogCategory::orderBy('id','desc')->get());
        $categories = Category::all();
        $data = BlogCategory::orderBy('id','desc')->get();
         return view('cblog.index',compact('data','categories'));
     }

     //*** GET Request
     public function create()
     {
         return view('cblog.create');
     }

     //*** POST Request
     public function store(Request $request)
     {
         //--- Validation Section
         $rules = [
                'name' => 'unique:blog_categories',
                'slug' => 'unique:blog_categories'
                 ];
         $customs = [
                'name.unique' => 'This name has already been taken.',
                'slug.unique' => 'This slug has already been taken.'
                    ];
                    $validator = Validator::make($request->all(), $rules, $customs);
                    if ($validator->fails()) {
                      return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
                    }
         //--- Validation Section Ends
         $today = date("Y-m-d H:i:s");
         $catName = $request->name;
         $description = $request->description;

         if(!empty($request->slug)){
            $slug = $request->slug;
         }else{
            $slug = Str::slug($catName);
         }

         //--- Logic Section
         $data = new BlogCategory;
         $data->name = $catName;
         $data->slug = $slug;
         $data->description = $description;
         $data->pcategory_id = $request->pcategory_id;
         $data->subcategory_id = $request->subcategory_id;
         $data->subsubcategory_id = $request->subsubcategory_id;
         $data->status = $request->status;
         $data->created_at =$today;
         if ($request->hasFile('banner')) {
            $data->banner = $request->banner->store('uploads/blogs/banner');
            ImageOptimizer::optimize(base_path('public/') . $data->banner);
        }
         if($data->save()){

            flash(__('Category Added Successfully'))->success();
            return redirect()->route('admin-cblog-index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
         //--- Redirect Section Ends
     }

     //*** GET Request
     public function edit($id)
     {
         $catInfo = BlogCategory::findOrFail($id);
         $categories = Category::all();
         return view('cblog.edit',compact('catInfo','categories'));
     }

     //*** POST Request
     public function update(Request $request, $id)
     {
         //--- Validation Section
         $rules = [
                'name' => 'unique:blog_categories,name,'.$id,
                'slug' => 'unique:blog_categories,slug,'.$id
                 ];
         $customs = [
                'name.unique' => 'This name has already been taken.',
                'slug.unique' => 'This slug has already been taken.'
                    ];
         $validator = Validator::make($request->all(), $rules, $customs);
         if ($validator->fails()) {
           return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
         }
         //--- Validation Section Ends
         $today = date("Y-m-d H:i:s");
         $catName = $request->name;
         $description = $request->description;
         if(!empty($request->slug)){
            $slug = $request->slug;
         }else{
            $slug = Str::slug($catName);
         }
         //--- Logic Section
         $data = BlogCategory::findOrFail($id);
         $data->name =$catName;
         $data->slug =$slug;
         $data->description = $description;
         $data->pcategory_id = $request->pcategory_id;
         $data->subcategory_id = $request->subcategory_id;
         $data->subsubcategory_id = $request->subsubcategory_id;
         $data->status = $request->status;
         if ($request->hasFile('banner')) {
             $data->banner = $request->banner->store('uploads/blogs/banner');
             ImageOptimizer::optimize(base_path('public/') . $data->banner);
         }else{
            $data->banner = $request->previous_photo;
         }
         $data->created_at =$today;
         $data->updated_at = $today;

         //--- Logic Section Ends

         if($data->save()){

            flash(__('Category has been updated successfully'))->success();
            return redirect()->route('admin-cblog-index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }

     }

     //*** GET Request
     public function destroy($id)
     {
         $data = BlogCategory::findOrFail($id);

         //--- Check If there any blogs available, If Available Then Delete it
         if($data->blogs->count() > 0)
         {
             foreach ($data->blogs as $element) {
                 $element->delete();
             }
         }
         if ($data->banner!= null) {
            unlink($data->banner);
        }
         //--- Redirect Section
         if($data->delete()){

            flash(__('Category With Blog Post Deleted successfully'))->success();
            return redirect()->route('admin-cblog-index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
     }
}
