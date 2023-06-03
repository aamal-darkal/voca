<?php

namespace Database\Seeders;

use App\Models\Phrase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PhraseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $phrases = [
            [
                'id' => 1,
                'content' =>  'A regular full-body check-up should be done',
                'translation' => 'يجب عمل فحص دوري لكامل الجسم',
                'word_count' => 7 ,
                'order' => 1,
                'level_id' =>  1                      
            ],
            [
                'id' => 2,
                'content' =>  'Exposure to the sun should be ten minutes every day',
                'translation' => 'ينبغي التعرض لأشعة الشمس كل يوم عشرة دقائق',
                'word_count' => 10 ,
                'order' => 2    ,
                'level_id' =>  2                      
            ],
            [
                'id' => 3,
                'content' =>  'Algorithm is a set of sequential steps to achieve a specific goal',
                'translation' => 'الخورازمية هي مجموعة خطوات متسلسلة لتحقيق هدف محدد',
                'word_count' => 12 ,
                'order' => 3,
                'level_id' =>  2                      
            ],
        ];
        foreach($phrases as $phrase) {
            $phrase = Phrase::create($phrase);
            $phrase->participants()->attach(1, ['status' => Arr::random(['S' , 'C']) ]);
            $phrase->participants()->attach(2, ['status' => Arr::random(['S' , 'C']) ]);
        }       
    }
}