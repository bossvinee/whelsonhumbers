<?php

namespace App\Http\Controllers;

use App\Imports\AllocationsImport;
use App\Models\Allocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AllocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allocations = Allocation::all();
        return view('allocations.index',compact('allocations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('allocations.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paynumber' => 'required',
            'meet_a' => 'required',
            'meet_b' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('paynumber',$request->paynumber)->first();

        if($user)
        {
            $user_allocation = DB::table('allocations')
                            ->where('paynumber',$user->paynumber)
                            ->get();

            if($user_allocation->count() == 0)
            {
                $allocation = Allocation::create([
                    'paynumber' => $request->input('paynumber'),
                    'user_id' => $user->id,
                    'meet_a' => $request->input('meet_a'),
                    'meet_b' => $request->input('meet_b'),
                    'allocation_month' => $request->input('allocation_month'),
                    'meet_allocation' => 1,
                    'food_allocation' => 1,
                ]);
                $allocation->save();

                return redirect('allocations')->with('success','User has been allocated successfully');
            }else {
                return back()->with('error','The user has already been allocated.');
            }
        }

        return redirect()->back()->with('error','OOps, something wrong with your input.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function show(Allocation $allocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function edit(Allocation $allocation)
    {
        return view('allocations.edit',compact('allocation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Allocation $allocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Allocation $allocation)
    {
        //
    }

    public function getName($paynumber)
    {
        $name = DB::table("users")
          ->where("paynumber",$paynumber)
          ->pluck("user_id");

        return response()->json($name);
    }

    public function bulkAllocationForm()
    {
        return view('allocations.bulk');
    }



}
