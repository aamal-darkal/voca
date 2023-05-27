<?php

namespace Database\Seeders;

use App\Models\Dialect;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DialectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dialects = [            
            // ['locale' => 'arabic',  'key' => 'ar_SA' ,  'language_id' => 1],
            ['locale' => 'en-US',  'key' => 'en-us-x-sfg#male_1-local' ,  'language_id' => 2],
            ['locale' => 'en-GB',  'key' => 'en-gb-x-gbd-local' ,  'language_id' => 2],
    ];
    foreach($dialects as $dialect)
        Dialect::create($dialect);
    }
}
