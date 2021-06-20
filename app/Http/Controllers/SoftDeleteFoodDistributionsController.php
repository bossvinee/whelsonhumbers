<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\FoodDistribution;
use Illuminate\Http\Request;

class SoftDeleteFoodDistributionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fdists = FoodDistribution::onlyTrashed()->get();
        return view('fooddistribution.deteted-distrubutions',compact('fdists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $fdist = FoodDistribution::withTrashed()->where('id',$id)->first();
        $fdist->save();
        $fdist->restore();

        if ($fdist->restore())
        {
            $allocation = Allocation::where('paynumber',$fdist->paynumber)->first();
            $allocation->status = "issued";
            $allocation->food_allocation -= 1;
            $allocation->save();

            return redirect('fdistributions')->with('success','Distribution has been restored successfully');
        }
        else
        {
            return back()->with('error','Error occured while processing distrribution !!.');
        }

        return redirect('fdistributions')->with('error','Distribution could not be restored properly.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fdist = FoodDistribution::withTrashed()->where('id',$id)->first();
        $fdist->forceDelete();

        return redirect('fdistributions')->with('success','Distribution has been deleted Successfully');
    }
}
