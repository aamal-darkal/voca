<?php

namespace Database\Seeders;

use App\Models\WordType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WordTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wordTypes = [
            [
                'id' => 1,
                'name' => 'noun',
                'language_id' => 2,
            ],
            [
                'id' => 2,
                'name' => 'verb',
                'language_id' => 2,
            ],
            [
                'id' => 3,
                'name' => 'pronoun',
                'language_id' => 2,
            ],
            [
                'id' => 4,
                'name' => 'adjective',
                'language_id' => 2,
            ],
            [
                'id' => 5,
                'name' => 'adverb',
                'language_id' => 2,
            ],
            [
                'id' => 6,
                'name' => 'preposition',
                'language_id' => 2,
            ],
            [
                'id' => 7,
                'name' => 'article',
                'language_id' => 2,
            ],
        ];
        foreach($wordTypes as $wordType) {
            WordType::create($wordType);
        }
    }
}
