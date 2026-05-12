<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Admin\Validator;

class AdminController extends Controller
{
    public function profile()
    {
        $profile_data= Auth::user();
        return view('admin.profile')->with('profile_data', $profile_data);
    }

    // public function adminProfileUpdate(Request $request)
    // {
    //     $userdata= Auth::user();
    //     $userdata->fullname= $request->fullname;
    //     $userdata->username= $request->username;
    //     $userdata->email= $request->email;
    //     $userdata->phone= $request->phone;
    //     $userdata->address= $request->address;

    //     if ($userdata->save()) {
    //         $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Profile Updated Successfully.</b></div>";
    //         return response()->json(['status'=> 300,'message'=>$message]);
    //     }
    //     else{
    //         return response()->json(['status'=> 303,'message'=>'Server Error!!']);
    //     }

    // }

    public function adminProfileUpdate(Request $request)
    {
        $userdata= Auth::user();
        $userdata->name= $request->name;
        $userdata->email= $request->email;
        $userdata->phone= $request->phone;
        $userdata->address= $request->address;


        if ($userdata->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Profile Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }

    }

    public function changeAdminPassword(Request $request)
        {

            if(empty($request->opassword)){
                $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Old Password\" field..!</b></div>";
                return response()->json(['status'=> 303,'message'=>$message]);
                exit();
            }

            if(empty($request->password)){
                $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"New Password\" field..!</b></div>";
                return response()->json(['status'=> 303,'message'=>$message]);
                exit();
            }

            if(empty($request->password === $request->confirmpassword)){
                $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>New password doesn't match.</b></div>";
                return response()->json(['status'=> 303,'message'=>$message]);
                exit();
            }

        $hashedPassword = Auth::user()->password;

       if (\Hash::check($request->opassword , $hashedPassword )) {

         if (!\Hash::check($request->password , $hashedPassword)) {
                $where = [
                    'id'=>auth()->user()->id
                ];
                $passwordchange = User::where($where)->get()->first();
                $passwordchange->password =Hash::make($request->password);

                if ($passwordchange->save()) {
                    $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Password Change Successfully.</b></div>";
                    return response()->json(['status'=> 300,'message'=>$message]);
                }else{
                    return response()->json(['status'=> 303,'message'=>'Server Error!!']);
                }

        }else{
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>New password can not be the old password.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
                }

           }else{
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Old password doesn't match.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
             }

        }



        public function adminImageUpload(Request $request, $id)
        {
            $where = [
                'id'=>auth()->user()->id
            ];
            $user = User::where($where)->get()->first();

            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $rand = mt_rand(100000, 999999);
            $imageName = time(). $rand .'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $user->avatar_original= $imageName;
            $user->avatar= $imageName;


            if ($user->save()) {
                $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>User Image Upload Successfully.</b></div>";
                return response()->json(['status'=> 300,'message'=>$message]);
            }
            else{
                return response()->json(['status'=> 303,'message'=>'Server Error!!']);
            }
        }

        public function admin()
        {
            $users= User::where('user_type', '=', 'admin')->get();
            return view('staffs.admin', compact('users'));
        }

        public function addadmin()
        {
            return view('staffs.addadmin');
        }

        public function adminStore(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->user_type = "admin";
        $user->password = Hash::make($request->password);
        if($user->save()){
            flash(__('Admin has been inserted successfully'))->success();
            return redirect()->route('user.admin');
        }

        flash(__('Something went wrong'))->error();
        return back();
    }

    public function adminEdit($id)
        {
            $users= User::where('id', '=', decrypt($id))->first();
            // dd($users);
            return view('staffs.editadmin', compact('users'));
        }


    public function adminUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        if($user->save()){
            flash('Admin has been updated successfully')->success();
            return redirect()->route('user.admin');
        }
        flash('Something went wrong')->error();
        return back();
    }

    public function destroy($id)
    {
        if(User::destroy($id)){
            flash(__('Admin has been deleted successfully'))->success();
            return redirect()->route('user.admin');
        }

        flash(__('Something went wrong'))->error();
        return back();
    }





}
