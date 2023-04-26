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
            ['locale' => 'arabic',  'key' => 'ar_SA' ,  'language_id' => 1],
            ['locale' => 'american',  'key' => 'en_US' ,  'language_id' => 2],
            ['locale' => 'british',  'key' => 'en_UK' ,  'language_id' => 2],
    ];
    foreach($dialects as $dialect)
        Dialect::create($dialect);
    }
}
