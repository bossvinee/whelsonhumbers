<?php

namespace App\Imports;

use App\Models\Allocation;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class AllocationsImport implements ToCollection, WithHeadingRow
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

            if ($user) {
                $user_allocation = DB::table('users')
                                    ->join('allocations','users.paynumber','=','allocations.paynumber')
                                    ->select('users.*','allocations.*')
                                    ->where('users.paynumber',$user->paynumber)
                                    ->where('allocations.allocation',$row['month'])
                                    ->first();

                if (!$user_allocation) {

                    Allocation::create([
                        'paynumber' => $row['paynumber'],
                        'allocation' => $row['month'],
                        'meet_a' => $row['meet_a'],
                        'meet_b' => $row['meet_b'],
                        'meet_allocation' => 1,
                        'food_allocation' => 1,
                    ]);
                }
            }
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
