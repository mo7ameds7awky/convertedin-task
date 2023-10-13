<?php

namespace Database\Seeders;

use App\Enums\UserTypeEnum;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUsers = User::factory(50)->create(['type' => UserTypeEnum::ADMIN]);
        $nonAdminUsers = User::factory(50)->create(['type' => UserTypeEnum::USER]);
        foreach ($adminUsers as $adminUser) {
            Task::factory(200)->create([
                'assigned_to_id' => $nonAdminUsers->random(1)->first()->id,
                'assigned_by_id' => $adminUser->id,
            ]);
        }
    }
}
