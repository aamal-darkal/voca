<?php

namespace Database\Seeders;

use App\Models\Domain;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $domains = [
            [
                'id' => 1,
                'title' => 'Medicine',
                'description' => 'Medicines, diseases, body parts',
                'level_count' => 1,
                'language_id' => 2,
            ],
            [
                'id' => 2,
                'title' => 'Software Engineering',
                'description' => 'Programming concept, tools',
                'level_count' => 3,
                'language_id' => 2,
            ],
            [
                'id' => 3,
                'title' => 'Computer Engineering',
                'description' => 'Devices - Computer parts - maintenance',
                'level_count' => 2,
                'language_id' => 2,
            ],            
        ];        

        foreach($domains as $domain) {
            Domain::create($domain);
        }
        Domain::find(1)->langAlts()->attach([
            1 => ['title' => 'الطب' , 'description' => 'أدوية - أمراض - اجزاء الجسم',] , 
        ]);
        Domain::find(2)->langAlts()->attach([
            1 => ['title' => 'هندسة برمجيات' , 'description' => 'مفهوم البرمجة - الأدوات',] , 
        ]);
        Domain::find(1)->participants()->attach([1 => [ 'status' => 'C'] ]);
        Domain::find(2)->participants()->attach([1 => [ 'status' => 'C'] ,2 => [ 'status' => 'S']]);        
    }
}
