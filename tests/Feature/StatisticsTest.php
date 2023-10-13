<?php

use App\Enums\UserTypeEnum;
use App\Models\Statistic;
use App\Models\User;

it('test that statistics page rendered', function () {
    $admin = User::factory()->create(['type' => UserTypeEnum::ADMIN->value]);
    $response = $this->actingAs($admin)
        ->get('/statistics');

    $response->assertOk();
});

it('test that statistics page return 403 if the authenticated user is not admin user', function () {
    $normalUser = User::factory()->create(['type' => UserTypeEnum::USER->value]);
    $response = $this->actingAs($normalUser)
        ->get('/statistics');

    $response->assertStatus(403);
});

it('test that statistics page rendered and has data', function () {
    $admin = User::factory()->create(['type' => UserTypeEnum::ADMIN->value]);
    $users = User::factory()->count(10)->has(Statistic::factory())->create(['type' => UserTypeEnum::USER->value]);
    $response = $this->actingAs($admin)
        ->get('/statistics');

    $response->assertOk()
        ->assertDontSee('No statistics Yet.')
        ->assertSee($users->first()->name);
});
