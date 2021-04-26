<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Jobtitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobtitlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobtitles = Jobtitle::all();
        return view('jobtitles.index',compact('jobtitles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        return view('jobtitles.create',compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'title' => 'required|unique:jobtitles',
                'department' => 'required',
            ],
        );

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $title = Jobtitle::create([
            'title' => $request->input('title'),
            'department' => $request->input('department'),
        ]);
        $title->save();

        return redirect('jobtitles')->with('success','New job title has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jobtitle  $jobtitle
     * @return \Illuminate\Http\Response
     */
    public function show(Jobtitle $jobtitle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jobtitle  $jobtitle
     * @return \Illuminate\Http\Response
     */
    public function edit(Jobtitle $jobtitle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jobtitle  $jobtitle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jobtitle $jobtitle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jobtitle  $jobtitle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jobtitle $jobtitle)
    {
        //
    }

    public function getTitles($department)
    {
        $jobtitles = DB::table("jobtitles")
            ->where("department",$department)
            ->pluck("title");

        return response()->json($jobtitles);
    }
}
