<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::factory(50)->create([
            'created_by_id' => random_int(0, User::count()),
            'assigned_to_id' => random_int(0, User::count())
        ]);
    }
}
