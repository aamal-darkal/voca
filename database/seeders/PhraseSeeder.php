<?php

namespace Database\Seeders;

use App\Models\Phrase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
                'level_id' =>  1                      
            ],
            [
                'id' => 2,
                'content' =>  'Exposure to the sun should be ten minutes every day',
                'translation' => 'ينبغي التعرض لأشعة الشمس كل يوم عشرة دقائق',
                'word_count' => 10 ,
                'level_id' =>  1                      
            ],
            [
                'id' => 3,
                'content' =>  'Algorithm is a set of sequential steps to achieve a specific goal',
                'translation' => 'الخورازمية هي مجموعة خطوات متسلسلة لتحقيق هدف محدد',
                'word_count' => 12 ,
                'level_id' =>  2                      
            ],
        ];
        foreach($phrases as $phrase) {
            Phrase::create($phrase);
        }       
    }
}
