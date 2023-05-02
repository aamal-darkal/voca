<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = [
            [
                'id' => 1,
                'title' => 'body part',
                'description' => 'Scientific names of the body',
                'phrase_count' => 5,
                'order' => 1,
                'domain_id' => 1,
            ],
            [
                'id' => 2,
                'title' => 'algorithm',
                'description' => 'algorithm terms',
                'phrase_count' => 5,
                'order' => 1,
                'domain_id' => 2,
            ],
            [
                'id' => 3,
                'title' => 'programming',
                'description' => 'programming methods',
                'phrase_count' => 5,
                'order' => 2,
                'domain_id' => 2,
            ],
            [
                'id' => 4,
                'title' => 'Artificial intelligence',
                'description' => 'Artificial intelligence principles',
                'phrase_count' => 5,
                'order' => 3,
                'domain_id' => 2,
            ],
            [
                'id' => 5,
                'title' => 'Computer part',
                'description' => 'Hardware devices',
                'phrase_count' => 5,
                'order' => 1,
                'domain_id' => 3,
            ],
            [
                'id' => 6,
                'title' => 'maintenance',
                'description' => 'maintenance, devices',
                'phrase_count' => 5,
                'order' => 2,
                'domain_id' => 3,
            ],
        ];        

        foreach($levels as $level) {
            Level::create($level);
        }
        Level::find(1)->langAlts()->attach([
            1 => ['title' => 'أجزاء الجسم' , 'description' => 'الأسماء العلمية لأجزاء الجسم',] , 
        ]);
        Level::find(2)->langAlts()->attach([
            1 => ['title' => 'خوارزميات' , 'description' => 'مصطلحات الخوارزميات',] , 
        ]);

        Level::find(1)->participants()->attach([1 => [ 'status' => 'C'] ]);
        Level::find(2)->participants()->attach([1 => [ 'status' => 'C'] ,2 => [ 'status' => 'S']]);
        Level::find(3)->participants()->attach([1 => [ 'status' => 'S'] ,2 => [ 'status' => '']]);
        Level::find(4)->participants()->attach([1 => [ 'status' => ''] ,2 => [ 'status' => '']]);

    }
}
