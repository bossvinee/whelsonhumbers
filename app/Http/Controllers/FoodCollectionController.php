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
        $collections = FoodCollection::all();
        return view('collection.foodCollection.index',compact('collections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('collection.foodCollection.create',compact('users'));
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
                return back()->with('error','Collector id number is missing. ');
            }
        }

        $distribution = FoodDistribution::where('paynumber',$request->paynumber)
                                        ->where('allocation',$request->distribution)
                                        ->first();
        if ($distribution) {
            $collection = FoodCollection::create([
                'paynumber' => $request->input('paynumber'),
                'name' => $request->input('name'),
                'month' => $request->input('distribution'),
                'date_collected' => $request->input('date_collected'),
                'collected_by' => strip_tags($request->input('collected_by')),
                'id_number' => strip_tags($request->input('id_number')),
                'done_by' => Auth::user()->name,
            ]);
            $collection->save();

            if ($collection->save()) {

                $collection->fdistribution->status = "collected";
                $collection->fdistribution->date_collected = $request->date_collected;
                $collection->fdistribution->save();

                return redirect('fcollection')->with('success','Collection has been recorded successfully.');
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
