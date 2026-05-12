<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use Response;
use DB;

class ShippingAddessController extends Controller
{
    public function address(){
        return view("frontend.address.index");
    }

    public function address_add()
    {
        $redirect = 'addressbook';
        $region = Division::orderBy('name', 'asc')->get();
        $districts = District::orderBy('name', 'asc')->get();
        $upazilas = Upazila::orderBy('name', 'asc')->get();
        return view('frontend.customer.add_address', compact('region','districts','upazilas','redirect'));
    }
    // auto select
    public function getDistrictsByDivision(Request $request){
        $data=$request->all();
        $districts=DB::table('districts')
        ->where('districts.division_id','=',$data['division'])
        ->select('id','name')
        ->orderBy('name', 'asc')
        ->get();
        return Response::json($districts);
    }

    public function getThanaByDistrict(Request $request){
        $data=$request->all();
        $thana=DB::table('upazilas')
        ->where('upazilas.district_id','=',$data['districts'])
        ->select('id','name')
        ->orderBy('name', 'asc')
        ->get();
        return Response::json($thana);
    }

    public function getShipcost(Request $request){
        $data=$request->all();
        $ship=DB::table('upazilas')
        ->where('upazilas.id','=',$data['upazilas'])
        ->select('shipping_cost')
        ->get();
        return Response::json($ship);
    }

    // new shipping address add from checkout page
    public function newShippingAddress()
    {
        $region = Division::orderBy('name', 'asc')->get();
        $districts = District::orderBy('name', 'asc')->get();
        $upazilas = Upazila::orderBy('name', 'asc')->get();
        return view('frontend.partials.add_shipping_info', compact('region','districts','upazilas'));
    }

    public function address_book()
    {
        $address = ShippingAddess::where('user_id', '=', Auth::user()->id)->get();
        return view('frontend.customer.shipping_address', compact('address'));
    }

    public function address_book_store(Request $request)
    {
        // dd($request);
        $bcmnt = new ShippingAddess();
        $bcmnt->user_id = Auth::user()->id;
        $bcmnt->name = $request->name;
        $bcmnt->email = $request->email;
        $bcmnt->phone = $request->phone;
        $bcmnt->address = $request->address;
        $bcmnt->region = $request->region;
        $bcmnt->city = $request->city;
        $bcmnt->area = $request->area;
        $bcmnt->shipping_cost = $request->shipping_cost;
        $bcmnt->post_code = $request->post_code;
        $bcmnt->label = $request->label;
        $bcmnt->status = "1";
        
        if($bcmnt->save()){
            if (Auth::user()->shipping_address == 0 && Auth::user()->billing_address == 0 ) {
                $user = User::find(Auth::user()->id);
                $user->shipping_address = $bcmnt->id;
                $user->billing_address = $bcmnt->id;
                $user->save();
            }
            // dd($request->redirect);
            if($request->checkout){
                $user = User::find(Auth::user()->id);
                $user->shipping_address = $bcmnt->id;
                $user->save();
                flash(__('Default Shipping address update successfully'))->success();
                return redirect()->route('checkout.shipping_info');
            }else{
                if($request->redirect=='addressbook'){
                    flash(__('Default Shipping address update successfully'))->success();
                    return redirect()->route('address.book');
                }elseif($request->redirect=='medication'){
                    flash(__('Address updated successfully'))->success();
                    return redirect()->route('usermedication.index');
                }
            }
        }
        flash(__('Sorry! Something went wrong.'))->error();
        return back();
    }

    public function address_book_edit($id)
    {
        $address = ShippingAddess::where('id', '=', $id)->first();
        $region = Division::all();
        $districts = District::where('division_id', '=', $address->region)->get();
        $upazilas = Upazila::where('district_id', '=', $address->city)->get();
        return view('frontend.customer.edit_address', compact('address','region','districts','upazilas'));
    }

    public function address_book_update(Request $request,$id)
    {
        $user = ShippingAddess::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->region = $request->region;
        $user->city = $request->city;
        $user->area = $request->area;
        $user->post_code = $request->post_code;
        $user->shipping_cost = $request->shipping_cost;
        $user->label = $request->label;
        $user->save();

        if($user->save()){
            flash(__('Address updated successfully'))->success();
            return redirect()->route('address.book');
        }
        flash(__('Sorry! Something went wrong.'))->error();
        return back();
    }

    public function defaultShippingAddress()
    {
        $address = ShippingAddess::where('user_id', '=', Auth::user()->id)->get();
        return view('frontend.customer.default_shipping', compact('address'));
    }
    public function defaultShippingAddresschange()
    {
        $address = ShippingAddess::where('user_id', '=', Auth::user()->id)->get();
        return view('frontend.partials.change_shipping_info', compact('address'));
    }

    public function defaultBillingAddress()
    {
        $address = ShippingAddess::where('user_id', '=', Auth::user()->id)->get();
        return view('frontend.customer.billing_shipping', compact('address'));
    }

    public function default_billing_update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->billing_address = $request->default;

        if($user->save()){

            flash(__('Default Billing address update successfully'))->success();
            return redirect()->route('address.book');
        }
        flash(__('Sorry! Something went wrong.'))->error();
        return back();

    }

    public function default_shipping_update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->shipping_address = $request->default;

        if($user->save()){

            if($request->exchange){
                flash(__('Default Shipping address update successfully'))->success();
            return redirect()->route('checkout.shipping_info');
            }else{
                flash(__('Default Shipping address update successfully'))->success();
                return redirect()->route('address.book');
            }
        }
        flash(__('Sorry! Something went wrong.'))->error();
        return back();

    }


    public function shippingAddress(){
        $upazilas = Upazila::orderby('id', 'DESC')->get();
        return view("address.index",compact('upazilas'));
    }

    public function shippingAddressCreate()
    {
        $districts = District::all();
        $upazilas = Upazila::all();
        return view('address.create', compact('districts','upazilas'));

    }

    public function shippingAddressStore(Request $request)
    {
        $bcmnt = new Upazila();
        $bcmnt->district_id  = $request->city;
        $bcmnt->name = $request->area;
        $bcmnt->shipping_cost = $request->shipping_cost;
        if($bcmnt->save()){

            flash(__('Address created successfully'))->success();
            return redirect()->route('shippingaddress.index');
        }
        flash(__('Sorry! Something went wrong.'))->error();
        return back();
    }

    public function shippingAddressEdit($id)
    {
        $districts = District::all();
        $upazilas = Upazila::findOrFail(decrypt($id));
        // dd($upazilas);
        return view('address.edit', compact('districts','upazilas'));

    }


    public function shippingAddressUpdate(Request $request,$id)
    {
        $user = Upazila::find($id);
        $user->district_id = $request->city;
        $user->name = $request->area;
        $user->shipping_cost = $request->shipping_cost;
        $user->save();

        if($user->save()){
            flash(__('Address updated successfully'))->success();
            return redirect()->route('shippingaddress.index');
        }
        flash(__('Sorry! Something went wrong.'))->error();
        return back();
    }

    public function shippingAddressDelete($id)
    {
        if(Upazila::destroy($id)){
            flash('Address has been deleted successfully')->success();
            return redirect()->route('shippingaddress.index');
        }

        flash('Something went wrong')->error();
        return back();
    }

}
