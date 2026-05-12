<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use DataTables;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use App\Models\BlogComment;
use Auth;
use ImageOptimizer;
use Illuminate\Support\Str;

class BlogController extends Controller
{
 //*** JSON Request
 public function datatables()
 {
      $datas = Blog::orderBy('id','desc')->get();
      //--- Integrating This Collection Into Datatables
      return DataTables::of($datas)
                         ->editColumn('photo', function(Blog $data) {
                             $photo = $data->photo ? url('public/uploads/blogs/'.$data->photo):url('public/images/noimage.png');
                             return '<img src="' . $photo . '" alt="Image">';
                         })
                         ->addColumn('action', function(Blog $data) {
                             return '<div class="action-list"><a href="' . route('admin-blog-edit',$data->id) . '"> <i class="fas fa-edit"></i>Edit</a><a href="javascript:;" data-href="' . route('admin-blog-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                         })
                         ->rawColumns(['photo', 'action'])
                         ->toJson(); //--- Returning Json Data To Client Side
 }

 //*** GET Request
 public function index()
 {
    $data = Blog::orderBy('id','desc')->get();
    // dd($data);
     return view('blog.index', compact('data'));
 }

 //*** GET Request
 public function create()
 {
     $cats = BlogCategory::all();
     $categories = Category::all();
     return view('blog.create',compact('cats','categories'));
 }

 //*** POST Request
 public function store(Request $request)
 {
     //--- Validation Section
    $request->validate([
    'photo' => 'required|mimes:jpeg,jpg,png,svg'
]);
     //--- Logic Section
     $data = new Blog();

    if ($request->hasFile('photo')) {
    $file = $request->file('photo');
    $filename = time().'_'.$file->getClientOriginalName();
    $file->move(public_path('uploads/blogs'), $filename);

    $data->photo = 'uploads/blogs/'.$filename;

    ImageOptimizer::optimize(public_path($data->photo));
}
     $data->category_id = $request->category_id;
     $data->title = $request->title;
     $data->slug = Str::slug($request->title);
     $data->details = $request->details;
     $data->pcategory_id = $request->pcategory_id;
     $data->subcategory_id = $request->subcategory_id;
     $data->subsubcategory_id = $request->subsubcategory_id;
     $data->status = $request->status;
     $data->create_by = Auth::user()->name;
     //--- Logic Section Ends
//  dd($request->all());
     //--- Redirect Section
     if ($data->save()) {
        flash(__('Blog has been inserted successfully'))->success();

            return redirect()->route('admin-blog-index');

    } else {
        flash(__('Something went wrong'))->error();
        return back();
    }
 }

 //*** GET Request
 public function edit($id)
 {
     $cats = BlogCategory::all();
     $categories = Category::all();
     $data = Blog::findOrFail(decrypt($id));
    //  dd($data);
     return view('blog.edit',compact('data','cats','categories'));
 }

 //*** POST Request
 public function update(Request $request, $id)
 {



     $data = Blog::findOrFail($id);
    //  dd($data);
     $data->photo = $request->previous_photo;
     if ($request->hasFile('photo')) {
         $data->photo = $request->photo->store('uploads/blogs');
         ImageOptimizer::optimize(base_path('public/') . $data->photo);
     }
     $data->category_id = $request->category_id;
     $data->title = $request->title;
     $data->slug = Str::slug($request->title);
     $data->details = $request->details;
     $data->pcategory_id = $request->pcategory_id;
     $data->subcategory_id = $request->subcategory_id;
     $data->subsubcategory_id = $request->subsubcategory_id;
     $data->status = $request->status;
     $data->create_by = Auth::user()->name;
     if ($data->save()) {
        flash(__('Blog Post has been updated Successfully'))->success();
            return redirect()->route('admin-blog-index');
    } else {
        flash(__('Something went wrong'))->error();
        return back();
    }
     //--- Redirect Section Ends
 }

 //*** GET Request Delete
public function destroy($id)
{
    $data = Blog::findOrFail(decrypt($id));

    if ($data->photo != null) {
        $path = public_path($data->photo);

        if (file_exists($path)) {
            unlink($path);
        }
    }

    if ($data->delete()) {
        flash(__('Blog Post has been Deleted Successfully'))->success();
        return redirect()->route('admin-blog-index');
    } else {
        flash(__('Something went wrong'))->error();
        return back();
    }
}

    //  blog comments section
    public function comment()
    {
        $comment = BlogComment::where('status',1)->get();
        // dd($comment);
        return view('blog.comment', compact('comment'));
    }


    // comment delete
    public function commentdestroy($id)
    {
        if(BlogComment::destroy($id)){
            flash(__('Comment has been deleted successfully'))->success();
            return redirect()->route('admin-blog-comment');
        }
        flash(__('Something went wrong'))->error();
        return back();
    }
  // change status

    public function changeStatus(Request $request)
    {
        $data = BlogComment::find($request->id);
        $data->status = $request->status;
        $data->save();

        if($request->status==1){
            $data = BlogComment::find($request->id);
            $data->status = $request->status;
            $data->save();
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Active Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            $data = BlogComment::find($request->id);
            $data->status = $request->status;
            $data->save();
            $message ="<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Inactive Successfully.</b></div>";
        return response()->json(['status'=> 300,'message'=>$message]);
        }


    }






}
