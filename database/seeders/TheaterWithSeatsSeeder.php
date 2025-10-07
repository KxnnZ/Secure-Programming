<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theater;
use App\Models\Seat;

class TheaterWithSeatsSeeder extends Seeder
{
    public function run(): void
    {
        $theater = Theater::firstOrCreate(
            ['name' => 'Studio 1'],
            ['rows' => 7, 'cols' => 18] 
        );

        for ($r = 1; $r <= 7; $r++) {
            $rowLetter = chr(64 + $r); 
            for ($c = 1; $c <= 18; $c++) {
                Seat::firstOrCreate(
                    ['theater_id' => $theater->id, 'code' => $rowLetter.$c],
                    ['row' => $r, 'col' => $c, 'type' => $r <= 2 ? 'vip' : 'standard']
                );
            }
        }
    }
}
