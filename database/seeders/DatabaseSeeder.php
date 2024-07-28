<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Database\Factories\TaskFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user  = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $user->tasks()->createMany(Task::factory(10)->make()->toArray());
    }
}
