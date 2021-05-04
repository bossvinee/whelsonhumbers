<?php

namespace App\Http\Controllers;

use App\Imports\FoodDistributionImport;
use App\Mail\FoodDistributedMail;
use App\Models\Allocation;
use App\Models\FoodDistribution;
use App\Models\Jobcard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class FoodDistributionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fdists = FoodDistribution::where('status','=','Not Collected')->latest()->get();
        return view('fooddistribution.index',compact('fdists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $jobcards = Jobcard::where('card_type','=','food')->latest()->get();

        return view('fooddistribution.create',compact('users','jobcards'));
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
                if( $allocation_month->food_allocation >= 1)
                {
                    $food = FoodDistribution::create([
                        'department' => $request->input('department'),
                        'paynumber' => $request->input('paynumber'),
                        'name' => $request->input('name'),
                        'card_number' => $request->input('card_number'),
                        'issue_date' => $request->input('issue_date'),
                        'allocation' => $request->input('allocation'),
                        'done_by' => Auth::user()->name,
                    ]);
                    $food->save();

                    if($food->save())
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

                        $allocation_month->food_allocation -= 1;
                        $allocation_month->status = "issued";
                        $allocation_month->save();

                        return redirect('fdistributions')->with('success','Humber has been distributed successfully.');
                    }
                }
                else {

                    return back()->with('error','User has no allocation');
                }
            } else {
                return redirect('fdistributions')->with('info','User has no allocation');
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FoodDistribution  $foodDistribution
     * @return \Illuminate\Http\Response
     */
    public function show(FoodDistribution $foodDistribution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FoodDistribution  $foodDistribution
     * @return \Illuminate\Http\Response
     */
    public function edit(FoodDistribution $foodDistribution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FoodDistribution  $foodDistribution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FoodDistribution $foodDistribution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FoodDistribution  $foodDistribution
     * @return \Illuminate\Http\Response
     */
    public function destroy(FoodDistribution $foodDistribution)
    {
        //
    }

    public function getDepartment($paynumber)
    {
        $dpt = DB::table("users")
            ->where("paynumber",$paynumber)
            ->pluck("department");

        return response()->json($dpt);
    }

    public function getUsername($paynumber) {
        $name = DB::table("users")
          ->where("paynumber",$paynumber)
          ->pluck("name");

        return response()->json($name);
    }

    public function getAllocation($paynumber) {

        $allocation = Allocation::where('paynumber',$paynumber)
                    ->where('status','=',"not issued")
                    ->pluck('allocation');
        // dd($allocation);

        return response()->json($allocation);
    }

    public function bulkFoodDistribution() {
        $jobcards = Jobcard::latest()->get();
        return view('fooddistribution.bulk',compact('jobcards'));
    }

    public function bulkFoodUpload(Request $request) {

        $validator = Validator::make($request->all(),[
            'select_type' => 'required',
            'result' => 'required',
            'month' => 'required',
            'issue_date' => 'required',
            'card_number' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withError($validator)->withInput();
        }

        if ($request->select_type == "department") {

            $users = User::where('department',$request->result)->get();

            foreach ($users as $user) {

                $jobcard = Jobcard::where('card_number',$request->card_number)->first();

                if($jobcard->remaining > 0) {

                    if ($user->allocation) {

                        $user_allocation = Allocation::where('allocation',$request->month)
                                                    ->where('food_allocation','>',0)
                                                    ->where('paynumber',$user->paynumber)->first();

                        if ($user_allocation )
                        {
                            $distributor = FoodDistribution::create([
                                'department' => $user->department,
                                'paynumber' => $user->paynumber,
                                'name' => $user->name,
                                'card_number' => $request->input('card_number'),
                                'issue_date' => $request->input('issue_date'),
                                'allocation' => $user_allocation->allocation,
                                'done_by' => Auth::user()->name,
                            ]);
                            $distributor->save();

                            if($distributor->save())
                            {
                                if($request->month === $jobcard->card_month)
                                {
                                    $jobcard->issued += 1;
                                    $jobcard->remaining -= 1;
                                    $jobcard->save();

                                }else {

                                    $jobcard->remaining -= 1;
                                    $jobcard->extras_previous += 1;
                                    $jobcard->save();
                                }

                                $user_allocation->food_allocation -= 1;
                                $user_allocation->status = "issued";
                                $user_allocation->save();

                            }
                        }
                    }

                } else {

                    return redirect('jobcards')->with('error','System was unable to complete bulk department distribution . Please open a new jobcard .??');
                }


            }

            $dpt_manager = DB::table('users')
                            ->join('departments','users.paynumber','=','departments.manager')
                            ->select('users.*')
                            ->where('departments.department',$request->result)
                            ->first();

            $allocation = [
                'greeting' => 'Good day, '.$dpt_manager->name,
                'body' => "Food humbers for $request->month had been distribted to your department. You can now proceed with collection",
            ];

            try {
                Mail::to($dpt_manager->email)->send(new FoodDistributedMail($allocation));
            } catch (\Exception $e) {
                echo "Exception error -  ".$e;
            }

            return redirect('fdistributions')->with('success','Humber has been distributed successfully.');

        }

        if ($request->select_type == "etype") {

            $users = User::where('usertype',$request->result)->get();

            foreach ($users as $user) {

                if ($user->allocation) {

                    $user_allocation = Allocation::where('allocation',$request->month)->where('paynumber',$user->paynumber)->first();

                    if ($user_allocation )
                    {
                        $distributor = FoodDistribution::create([
                            'department' => $user->department,
                            'paynumber' => $user->paynumber,
                            'name' => $user->name,
                            'card_number' => $request->input('card_number'),
                            'issue_date' => $request->input('issue_date'),
                            'allocation' => $request->input('month'),
                            'done_by' => Auth::user()->name,
                        ]);
                        $distributor->save();
                    } else {
                        continue;
                    }
                }
            }
            return redirect('fdistributions')->with('success','Humber has been distributed successfully.');
        }

        return back()->with('error','Something wrong with your input');
    }

    public function getDisttibutionImport() {
        return view('fooddistribution.import');
    }

    public function fdistributionImportSend(Request $request) {

        $validator = Validator::make($request->all(),[
            'distributor' => 'required',

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Excel::import(new FoodDistributionImport,request()->file('distributor'));

        return redirect('fdistributions')->with('Data has been imported successfully');
    }

    public function addCollection($id) {

        $distributor = FoodDistribution::where('id',$id)->first();

        return view('fooddistribution.add-collection',compact('distributor'));
    }

    public function multiInsert() {
        $users =User::all();
        $jobcards = Jobcard::where('card_type','=','food')->latest()->get();
        return view('fooddistribution.multi',compact('users','jobcards'));
    }

    public function multiInsertPost() {


    }
}
