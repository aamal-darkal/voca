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
                'title' => 'الطب',
                'description' => 'أدوية - أمراض - اجزاء الجسم',
                'level_count' => 1,
                'order' => 1,
                'language_id' => 2,
            ],
            [
                'id' => 2,
                'title' => 'هندسة برمجيات',
                'description' => 'مفهوم البرمجة - الأدوات',
                'level_count' => 3,
                'order' => 2,
                'language_id' => 2,
            ],
            [
                'id' => 3,
                'title' => 'هندسة جواسيب',
                'description' => 'أجهزة - أجزاء الكمبيوتر - صيانة',
                'level_count' => 2,
                'order' => 3,
                'language_id' => 2,
            ],            
        ];        

        foreach($domains as $domain) {
            Domain::create($domain);
        }
        Domain::find(1)->langApps()->attach([
            2 => ['title' =>   'Medicine', 'description' =>  'Medicines, diseases, body parts' , ] , 
            3 => ['title' =>   'Mdcne', 'description' =>  'Medcies, diseases, body parts' , ] , 
        ]);
        Domain::find(2)->langApps()->attach([
            2 => ['title' =>  'Software Engineering' , 'description' =>  'Programming concept, tools',] , 
            3 => ['title' =>  'Sofre Engng' , 'description' =>  'Promi, ols',] , 
        ]);
        Domain::find(3)->langApps()->attach([
            2 => ['title' =>  'Computer Engineering' , 'description' =>  'Devices - Computer parts - maintenance',] , 
            3 => ['title' =>  'Comter Eneering' , 'description' =>  'Devs - Coterts - maisnance',] , 
        ]);
        Domain::find(1)->participants()->attach([1 => [ 'status' => 'C'] ]);
        Domain::find(2)->participants()->attach([1 => [ 'status' => 'C'] ,2 => [ 'status' => 'S']]);        
    }
}
