<?php

namespace App\Http\Controllers;

use App\Models\Jobcard;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $curr_month = date('FY');

        $jobcards = Jobcard::orderBy('created_at', 'ASC')
                            ->where('card_type','=','food')
                            ->where('card_month',$curr_month)->get();
        $jobcards_count = $jobcards->count();
        return view('home',compact('jobcards'));
    }
}
