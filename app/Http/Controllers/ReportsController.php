<?php

namespace App\Http\Controllers;

use App\Models\FoodDistribution;
use App\Models\Jobcard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportsController extends Controller
{
    public function jobcardReport() {

        $jobcards = Jobcard::all();
        return view('reports.jobcard',compact('jobcards'));
    }

    public function jobcardReportPost(Request $request) {

        $jobcards = Jobcard::all();

        $validator = Validator::make($request->all(),[
            'card_number' => 'required'
        ]);

        if($validator->fails()) {

            return back()->withErrors($validator)->withInput();
        }

        $jobcard =  Jobcard::where('card_number',$request->card_number)->first();

        if ($jobcard) {

            $collections = FoodDistribution::where('card_number',$jobcard->card_number)->latest()->get();

            return view('reports.jobcard',compact('collections','jobcards'));
        }
    }

    public function getMonthlyReport() {

        $months = FoodDistribution::select('allocation')->distinct()->get();
        return view('reports.month',compact('months'));
    }

    public function getMonthlyReportPost(Request $request) {

        $months = FoodDistribution::select('allocation')->distinct()->get();

        $validator = Validator::make($request->all(),[
            'month' => 'required'
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $month = $request->month;
        $collections = FoodDistribution::where('allocation',$request->month)
                                            ->where('status','=','Collected')
                                            ->get();

        return view('reports.month',compact('collections','months','month'));
    }

    public function getUserReport() {

        $users = User::all();
        return view('reports.user-collection',compact('users'));
    }
    public function getUserReportPost(Request $request) {
        $users = User::all();
        $validator = Validator::make($request->all(),[
            'paynumber' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user_collections = FoodDistribution::where('paynumber',$request->paynumber)->where('status','=','Collected')->get();
        return view('reports.user-collection',compact('users','user_collections'));
    }


}
