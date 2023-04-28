<?php

namespace Database\Seeders;

use App\Models\Word;
use App\Models\Phrase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $words = [            
            [
                'id' => 1,
                'content' =>  'A',
                'word_type_id' => 7,
            ],
            [
                'id' => 2,
                'content' =>  'regular',
                'word_type_id' => 4,
            ],
            [
                'id' => 3,
                'content' =>  'full-body',
                'word_type_id' => 4,
            ],
            [
                'id' => 4,
                'content' =>  'check-up',
                'word_type_id' => 1,
            ],
            [
                'id' => 5,
                'content' =>  'should',
                'word_type_id' => 3,
            ],
            [
                'id' => 6,
                'content' =>  'be',
                'word_type_id' => 5,
            ],
            [
                'id' => 7,
                'content' =>  'done',
                'word_type_id' => 2,
            ],            
        ];
        foreach($words as $word) {
            Word::create($word);
        } 
        Phrase::find(1)->words()->attach([
            1 => [
                'translation' => 'أداة نكرة', 
                'order' => 1,
                ] , 
            2 => [
                'translation' => 'دوري', 
                'order' => 2,
                ] , 
            3 => [
                'translation' => 'كامل الجسم', 
                'order' => 3,
                ] , 
            4 => [
                'translation' => 'فحص كامل', 
                'order' => 4,
                ] , 
            5 => [
                'translation' => 'يجب', 
                'order' => 5,
                ] , 
            6 => [
                'translation' => 'فعل كون', 
                'order' => 6,
                ] , 
            7 => [
                'translation' => 'عملهس', 
                'order' => 7,
                ] , 
            
        ]);               
    }
}
