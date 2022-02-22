<?php

namespace Database\Seeders;

use App\Settings;
use App\Team;
use App\Ticket;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'email'    => 'admin@handesk.io',
            'password' => Hash::make('admin'),
            'admin'    => true,
        ]);

        Settings::create();

        // $teams = Team::factory()->count(4)->create();

        // $teams->each(function ($team) {
        //     $team->memberships()->create([
        //         'user_id' => User::factory()->create()->id,
        //     ]);

        //     $team->tickets()->createMany(Ticket::factory()->count(4)->make()->toArray());
        // });

        // Ticket::factory()->create();
    }
}
