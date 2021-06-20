<?php

namespace App\Http\Controllers;

use App\Imports\MeetDistributionImport;
use App\Models\Allocation;
use App\Models\Jobcard;
use App\Models\MeetDistribution;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class MeetDistributionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mdists = MeetDistribution::where('status','=','Not Collected')->latest()->get();
        return view('meetdistribution.index',compact('mdists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $jobcards = Jobcard::where('card_type','=','meet')->latest()->get();
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
        $getcard = Jobcard::where('card_number',$request->card_number)->first();
        $user = User::where('paynumber',$request->paynumber)->first();

        $validator = Validator::make($request->all(),[
            'department' => 'required',
            'paynumber' => 'required',
            'name' => 'required',
            'card_number' => 'required',
            'issue_date' => 'required',
            'allocation' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($getcard->remaining > 0)
        {
            // check user allocation
            if( $user->allocation)
            {
                $allocation_month = Allocation::where('paynumber',$request->paynumber)
                                    ->where('allocation',$request->allocation)
                                    ->first();
                if( $allocation_month->meet_allocation >= 1)
                {
                    $meat = MeetDistribution::create([
                        'department' => $request->input('department'),
                        'paynumber' => $request->input('paynumber'),
                        'name' => $request->input('name'),
                        'card_number' => $request->input('card_number'),
                        'issue_date' => $request->input('issue_date'),
                        'allocation' => $request->input('allocation'),
                        'done_by' => Auth::user()->name,
                        'meet_a' => $allocation_month->meet_a,
                        'meet_b' => $allocation_month->meet_b,
                    ]);
                    $meat->save();

                    if($meat->save())
                    {
                        if($request->allocation === $getcard->card_month)
                        {
                            $getcard->issued += 1;
                            $getcard->remaining -= 1;
                            $getcard->save();

                        }else {

                            $getcard->remaining -= 1;
                            $getcard->extras_previous += 1;
                            $getcard->save();
                        }

                        $allocation_month->meet_allocation -= 1;
                        $allocation_month->status = "issued";
                        $allocation_month->save();

                        return redirect('mdistributions')->with('success','Humber has been distributed successfully.');
                    }
                }
                else {

                    return back()->with('error','User has no allocation');
                }
            } else {
                return redirect('mdistributions')->with('info','User has no allocation');
            }
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
        $distribution = MeetDistribution::findOrFail($id);
        return view('meetdistribution.edit',compact('distribution'));
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

    public function getMeetAllocation($paynumber) {

        $allocation = Allocation::where('paynumber',$paynumber)
                    ->where('meet_allocation','=',1)
                    ->pluck('allocation');
        // dd($allocation);

        return response()->json($allocation);
    }

    public function getDisttibutionImport() {
        return view('meetdistribution.import');
    }

    public function mdistributionImportSend(Request $request) {

        $validator = Validator::make($request->all(),[
            'distributor' => 'required',

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Excel::import(new MeetDistributionImport,request()->file('distributor'));

        return redirect('mdistributions')->with('Data has been imported successfully');
    }
}
