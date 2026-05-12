<?php

namespace App\Http\Controllers;

use App\Models\DocDepartment;
use Illuminate\Http\Request;

class DocDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deps = DocDepartment::all();
        // dd()
        return view('department.index', compact('deps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('department.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new DocDepartment;
        $user->dep_name = $request->dep_name;
        $user->dep_code = $request->dep_code;
        $user->dep_status = $request->dep_status;
        if($user->save()){
                flash(__('Department has been inserted successfully'))->success();
                return redirect()->route('department.index');
        }

        flash(__('Something went wrong'))->error();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DocDepartment  $docDepartment
     * @return \Illuminate\Http\Response
     */
    public function show(DocDepartment $docDepartment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DocDepartment  $docDepartment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd("controller called");
        $deps = DocDepartment::findOrFail(decrypt($id));
        return view('department.edit', compact('deps'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DocDepartment  $docDepartment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $deps = DocDepartment::findOrFail($id);
        $deps->dep_name = $request->dep_name;
        $deps->dep_code = $request->dep_code;
        $deps->dep_status = $request->dep_status;
        if($deps->save()){
                flash(__('Department has been updated successfully'))->success();
                return redirect()->route('department.index');
        }

        flash(__('Something went wrong'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DocDepartment  $docDepartment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // DocDepartment::destroy($id);
        if(DocDepartment::destroy($id)){
            flash(__('Department has been deleted successfully'))->success();
            return redirect()->route('department.index');
        }

        flash(__('Something went wrong'))->error();
        return back();
    }
}
