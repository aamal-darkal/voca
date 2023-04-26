<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Level;
use App\Models\Participant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(DialectSeeder::class);
        $this->call(ParticipantSeeder::class);
        $this->call(DomainSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(PhraseSeeder::class);
        $this->call(WordSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
