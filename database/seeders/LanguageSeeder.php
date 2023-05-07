<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            [
                'id' => 1,
                'name' => 'عربي',
                'key' => 'ar'
            ],
            [
                'id' => 2,
                'name' => 'English',
                'key' => 'en'
            ],
            [
                'id' => 3,
                'name' => 'سنسكريتي',
                'key' => 'sn'
            ],
        ];
        foreach ($languages as $language)
            Language::create($language);
    }
}
