<?php

namespace App\Console\Commands;

use App\Models\Allocation;
use App\Models\User;
use Illuminate\Console\Command;

class MonthlyAllocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'allocation:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Users food humber monthly allocation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();

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

                    if($allocation->save()) {
                        
                        $user->fcount += 1;
                        $user->mcount += 1;
                        $user->save();
                    }
                } else {
                    continue;
                }
            }
        }
    }
}
