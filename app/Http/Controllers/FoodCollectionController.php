<?php

namespace App\Http\Controllers;

use App\Models\FoodCollection;
use App\Models\FoodDistribution;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FoodCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fdists = FoodDistribution::where('status','=','Collected')->latest()->get();
        return view('fooddistribution.all-collection',compact('fdists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('fooddistribution.collection',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $distribution = FoodDistribution::where('paynumber',$request->paynumber)
                                        ->where('allocation',$request->distribution)
                                        ->first();

        $validator = Validator::make($request->all(),[
            'paynumber' => 'required',
            'name' => 'required',
            'distribution' => 'required',
            'date_collected' => 'required',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // check if collected by is supplied by
        if (!empty($request->collected_by) || $request->collected_by !== null) {

            if(empty($request->id_number) || $request->id_number == null) {
                return back()->with('error','Collector ID number is missing. ');
            } else {

                if ($distribution) {

                    $distribution->status = "Collected";
                    $distribution->collected_by = $request->collected_by;
                    $distribution->id_number = $request->id_number;
                    $distribution->save();

                    return redirect('fcollection')->with('success','Record has been updated successfully.');

                } else {

                    return back()->with('error','Distribution does not exist.');
                }

            }
        }

        if ($distribution) {

            $distribution->status = "Collected";
            $distribution->save();

            return redirect('fcollection')->with('success','Record has been updated successfully.');

        } else {

            return back()->with('error','Distribution does not exist.');
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

    public function getFdistribution($paynumber) {
        $distribution = FoodDistribution::where('paynumber',$paynumber)
        ->where('status','=',"not collected")
        ->pluck('allocation');

        return response()->json($distribution);
    }
}
