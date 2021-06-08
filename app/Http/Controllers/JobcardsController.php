<?php

namespace App\Http\Controllers;

use App\Models\Jobcard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobcardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobcards = Jobcard::all();
        return view('jobcards.index',compact('jobcards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jobcards.create');
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
            'card_number' => 'required|unique:jobcards',
            'date_opened' => 'required',
            'card_month' => 'required',
            'card_type' => 'required',
            'quantity' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        if( $request->card_type == 'meet')
        {
            $meet_cards = Jobcard::where('card_type','=','meet')->latest()->get();

            if($meet_cards->count() > 0)
            {
                foreach ($meet_cards as $mcard)
                {
                    if($mcard->remaining > 0)
                    {
                        return back()->with("error","Please complete Job card No: $mcard->card_number with pending units.!! ");
                    }else{
                            $jobcard = Jobcard::create([
                                'card_number' => $request->input('card_number'),
                                'date_opened' => $request->input('date_opened'),
                                'card_month' => $request->input('card_month'),
                                'card_type' => $request->input('card_type'),
                                'quantity' => $request->input('quantity'),
                                'remaining' => $request->input('quantity'),
                            ]);
                            $jobcard->save();

                            return redirect('jobcards')->with('success','New job card has been created successfully');
                    }
                }
            }
            else{

                $jobcard = Jobcard::create([
                    'card_number' => $request->input('card_number'),
                    'date_opened' => $request->input('date_opened'),
                    'card_month' => $request->input('card_month'),
                    'card_type' => $request->input('card_type'),
                    'quantity' => $request->input('quantity'),
                    'remaining' => $request->input('quantity'),
                ]);
                $jobcard->save();

                return redirect('jobcards')->with('success','New job card has been created successfully');
            }

        }else {

            $food_cards = Jobcard::where('card_type','=','food')->latest()->get();

            if($food_cards->count() > 0)
            {
                foreach ($food_cards as $fcard)
                {
                    if($fcard->remaining > 0)
                    {
                        return back()->with("error","Please complete Job card No: $fcard->card_number with pending units.!! ");
                    }else{
                            $jobcard = Jobcard::create([
                                'card_number' => $request->input('card_number'),
                                'date_opened' => $request->input('date_opened'),
                                'card_month' => $request->input('card_month'),
                                'card_type' => $request->input('card_type'),
                                'quantity' => $request->input('quantity'),
                                'remaining' => $request->input('quantity'),
                            ]);
                            $jobcard->save();

                            return redirect('jobcards')->with('success','New job card has been created successfully');
                    }
                }
            }
            else
            {
                $jobcard = Jobcard::create([
                    'card_number' => $request->input('card_number'),
                    'date_opened' => $request->input('date_opened'),
                    'card_month' => $request->input('card_month'),
                    'card_type' => $request->input('card_type'),
                    'quantity' => $request->input('quantity'),
                    'remaining' => $request->input('quantity'),
                ]);
                $jobcard->save();

                return redirect('jobcards')->with('success','New job card has been created successfully');
            }
        }

        return redirect('jobcards')->with('error',"There's something wrong with your input");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jobcard  $jobcard
     * @return \Illuminate\Http\Response
     */
    public function show(Jobcard $jobcard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jobcard  $jobcard
     * @return \Illuminate\Http\Response
     */
    public function edit(Jobcard $jobcard)
    {
        return view('jobcards.edit',compact('jobcard'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jobcard  $jobcard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jobcard $jobcard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jobcard  $jobcard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jobcard $jobcard)
    {
        //
    }
}
