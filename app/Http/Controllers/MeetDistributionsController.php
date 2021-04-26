<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Jobcard;
use App\Models\MeetDistribution;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MeetDistributionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $jobcards = Jobcard::where('card_type','=','meet')->get();

        return view('meetdistribution.create',compact('users','jobcards'));
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
            'department' => 'required',
            'paynumber' => 'required',
            'name' => 'required',
            'card_number' => 'required',
            'issue_date' => 'required',
            'month' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $mdist = MeetDistribution::create([
            'department' => $request->input('department'),
            'paynumber' => $request->input('paynumber'),
            'name' => $request->input('name'),
            'card_number' => $request->input('card_number'),
            'issue_date' => $request->input('issue_date'),
            'month' => $request->input('month'),
        ]);
        $mdist->save();

        $getcard = Jobcard::where('card_number',$request->card_number)->first();
        if($getcard)
        {
            $getcard->issued += 1;
            $getcard->remaining -= 1;
            $getcard->save();
        }

        $getallocation = Allocation::where('paynumber',$request->paynumber)->first();
        if($getallocation)
        {
            $getallocation->meet_allocation -= 1;
            $getallocation->save();
        }

        dd("all operations perfomed successfully");
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
