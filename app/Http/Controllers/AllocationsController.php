<?php

namespace App\Http\Controllers;

use App\Imports\AllocationsImport;
use App\Models\Allocation;
use App\Models\Department;
use App\Models\User;
use App\Models\Usertype;
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
        $users = User::where('activated',1)->get();
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
            'allocation' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('paynumber',$request->paynumber)->first();

        if($user)
        {
            $user_alloc = DB::table('allocations')
                            ->join('users','users.paynumber','=','allocations.paynumber')
                            ->select('users.name','allocations.*')
                            ->where('allocations.paynumber',$user->paynumber)
                            ->get();

            $user_allocation = DB::table('allocations')
                            ->where('paynumber',$user->paynumber)
                            ->where('allocation',$request->allocation)
                            ->get();

            if($user_alloc->count() > 0) {

                if($user_allocation->count() == 0)
                {
                    $allocation = Allocation::create([
                        'paynumber' => $request->input('paynumber'),
                        'allocation' => strip_tags($request->input('allocation')),
                        'meet_a' => $user_alloc->meet_a,
                        'meet_b' => $user_alloc->meet_b,
                        'meet_allocation' => 1,
                        'food_allocation' => 1,

                    ]);
                    $allocation->save();

                    return redirect('allocations')->with('success','User has been allocated successfully');
                }else {
                    return back()->with('error','The user has already been allocated.');
                }

            } else {

                $allocation = Allocation::create([
                    'paynumber' => $request->input('paynumber'),
                    'allocation' => strip_tags($request->input('allocation')),
                    'meet_a' => $request->input('meet_a'),
                    'meet_b' => $request->input('meet_b'),
                    'meet_allocation' => 1,
                    'food_allocation' => 1,
                ]);
                $allocation->save();

                return redirect('allocations')->with('success','User has been allocated successfully');
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
        $validator = Validator::make($request->all(), [
            'meet_a' => 'required',
            'meet_b' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $allocation->meet_a = $request->input('meet_a');
        $allocation->meet_b = $request->input('meet_b');
        $allocation->save();

        return redirect('allocations')->with('success','Allocation has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $allocation = Allocation::findOrFail($id);
        $allocation->delete();

        return redirect('allocations')->with('success','Allocation has been deleted Successfully');
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

    public function allAllocations()
    {
        $users = User::all();

        // foreach ($users as $user) {

        //     $month_allocation = date('FY');

        //     if($user->allocation) {
        //         // check if user has been allocated for that month
        //         $allocation_user = Allocation::where('allocation',$month_allocation)->first();
        //         if (!$allocation_user )
        //         {
        //             $allocation = Allocation::create([
        //                 'allocation' => $month_allocation,
        //                 'paynumber' => $user->paynumber,
        //                 'food_allocation' => 1,
        //                 'meet_allocation' => 1,
        //                 'meet_a' => $user->allocation->meet_a,
        //                 'meet_b' => $user->allocation->meet_b,
        //             ]);
        //             $allocation->save();
        //         } else {
        //             continue;
        //         }
        //     }
        // }

        return redirect('allocations')->with('success','Users has been allocated Successfully');
    }

    public function getDepartmentalUsers($department)
    {
        if($department == "department") {
            $name = DB::table("departments")
            ->where('id','>=',0)
            ->pluck("department");
            return response()->json($name);
        }

        if( $department == "etype") {

            $name = DB::table("usertypes")
            ->where('id','>=',0)
            ->pluck("type");
            return response()->json($name);
        }

    }


    public function bulkAllocationInsert(Request $request) {

        $validator = Validator::make($request->all(),[
            'select_type' => 'required',
            'result' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // check if selection is either usertype or department
        if ($request->select_type == "department")
        {
            $users = User::where('department',$request->result)->get();
            foreach ($users as $user) {

                $month_allocation = date('FY');

                if($user->allocation) {
                    // check if user has been allocated for that month
                    $allocation_user = Allocation::where('allocation',$month_allocation)
                                                    ->where('paynumber',$user->paynumber)
                                                    ->first();
                    if (!$allocation_user )
                    {
                        $allocation = Allocation::create([
                            'allocation' => $month_allocation,
                            'paynumber' => $user->paynumber,
                            'food_allocation' => 1,
                            'meet_allocation' => 1,
                            'meet_a' => $user->allocation->meet_a,
                            'meet_b' => $user->allocation->meet_b,
                        ]);
                        $allocation->save();
                    } else {
                        continue;
                    }
                }

            }

            return redirect('allocations')->with('success',"$request->result department has been allocated successfully");

        }

        if ($request->select_type == "etype")
        {
            $usertypes = User::where('usertype',$request->result)->get();

            foreach ($usertypes as $user) {

                $month_allocation = $user->paynumber.date('FY');

                if($user->allocation) {
                    // check if user has been allocated for that month
                    $allocation_user = Allocation::where('allocation',$month_allocation)->first();
                    if (!$allocation_user )
                    {
                        $allocation = Allocation::create([
                            'allocation' => $month_allocation,
                            'paynumber' => $user->paynumber,
                            'food_allocation' => 1,
                            'meet_allocation' => 1,
                            'meet_a' => $user->allocation->meet_a,
                            'meet_b' => $user->allocation->meet_b,
                        ]);
                        $allocation->save();
                    } else {
                        continue;
                    }
                }

            }

            return redirect('allocations')->with('success',"$request->result type has been allocated successfully");

        }

        return redirect('bulk-allocation')->with('error','System was unable to allocate users');
    }

}
