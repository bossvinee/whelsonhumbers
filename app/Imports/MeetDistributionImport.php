<?php

namespace App\Imports;

use App\Models\Allocation;
use App\Models\MeetDistribution;
use App\Models\User;
use App\Models\Jobcard;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class MeetDistributionImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $user = User::where('paynumber',$row['paynumber'])->first();

            $getcard = Jobcard::where('card_number',$row['card_number'])->first();

            if($getcard) {

                $remaining = Jobcard::where('card_number',$row['card_number'])->first()->remaining;

                if($remaining > 0 )
                {

                    // check user allocation
                    if( $user->allocation)
                    {
                        $allocation_month = Allocation::where('paynumber',$row['paynumber'])
                                            ->where('allocation',$row['allocation'])
                                            ->first();
                        if( $allocation_month->meet_allocation >= 1)
                        {
                            $meet = MeetDistribution::create([
                                'department' => $row['department'],
                                'paynumber' => $row['paynumber'],
                                'name' => $user->name,
                                'card_number' => $row['card_number'],
                                'issue_date' => $row['issue_date'],
                                'allocation' => $row['allocation'],
                                'done_by' => Auth::user()->name,
                                'meet_a' => $allocation_month->meet_a,
                                'meet_b' => $allocation_month->meet_b,
                            ]);
                            $meet->save();

                            if($meet->save())
                            {
                                if($row['allocation'] === $getcard->card_month)
                                {
                                    $getcard->issued += 1;
                                    $getcard->remaining -= 1;
                                    $getcard->save();

                                }else {

                                    $getcard->remaining -= 1;
                                    $getcard->extras_previous += 1;
                                    $getcard->save();
                                }

                                $allocation_month->meet_allocation -= 1;
                                $allocation_month->status = "issued";
                                $allocation_month->save();
                            }
                        }
                    }
                } else {
                    return redirect('jobcards')->with('error','System was unable to complete the import please open a new job card ???');
                }
            } else {
                return back()->with('error','Jobcard does not exist');
            }
        }

        return redirect('mdistributions')->with('success','Data has been imported successfully');
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
