<?php

use App\Enums\UserTypeEnum;
use App\Jobs\Statistics\UpdateStatistics;
use App\Models\Task;
use App\Models\User;

it('test that tasks list page rendered', function () {
    $admin = User::factory()->create(['type' => UserTypeEnum::ADMIN->value]);
    $response = $this->actingAs($admin)
        ->get('/tasks');

    $response->assertOk();
});

it('test that tasks list page return 403 if the authenticated user is not admin user', function () {
    $admin = User::factory()->create(['type' => UserTypeEnum::ADMIN->value]);
    $normalUser = User::factory()->create(['type' => UserTypeEnum::USER->value]);
    Task::factory()->count(15)->create([
        'assigned_to_id' => $normalUser->id,
        'assigned_by_id' => $admin->id,
    ]);

    $response = $this->actingAs($normalUser)
        ->get('/tasks');

    $response->assertStatus(403);
});

it('show that tasks index has no data', function () {
    $admin = User::factory()->create(['type' => UserTypeEnum::ADMIN->value]);
    $response = $this->actingAs($admin)->get('/tasks');

    $response->assertOk()
        ->assertSee('No Tasks Yet.');
});

it('show that tasks index has data', function () {
    $admin = User::factory()->create(['type' => UserTypeEnum::ADMIN->value]);
    $normalUser = User::factory()->create(['type' => UserTypeEnum::USER->value]);
    $tasks = Task::factory()->count(15)->create([
        'assigned_to_id' => $normalUser->id,
        'assigned_by_id' => $admin->id,
    ]);
    $response = $this->actingAs($admin)->get('/tasks');

    $response->assertOk()
        ->assertSee($tasks->first()->title)
        ->assertDontSee('No Tasks Yet.');
});

it('show that tasks index has data paginated', function () {
    $admin = User::factory()->create(['type' => UserTypeEnum::ADMIN->value]);
    $normalUser = User::factory()->create(['type' => UserTypeEnum::USER->value]);
    Task::factory()->count(15)->create([
        'assigned_to_id' => $normalUser->id,
        'assigned_by_id' => $admin->id,
    ]);
    $response = $this->actingAs($admin)->get('/tasks');

    $response->assertOk()
        ->assertDontSee('No Tasks Yet.')
        ->assertSee('Next');
});

it('test that create tasks page rendered', function () {
    $admin = User::factory()->create(['type' => UserTypeEnum::ADMIN->value]);

    $response = $this->actingAs($admin)
        ->get('/tasks/create');

    $response->assertOk();
});

it('test that admin user create tasks', function () {
    $admin = User::factory()->create(['type' => UserTypeEnum::ADMIN->value]);
    $normalUser = User::factory()->create(['type' => UserTypeEnum::USER->value]);
    $task = [
        'assignee' => $normalUser->id,
        'assigner' => $admin->id,
        'title' => 'test title',
        'description' => 'test description',
    ];
    $response = $this->actingAs($admin)
        ->post('/tasks', $task);

    $response->assertStatus(302);
    $this->assertDatabaseHas('tasks', [
        'assigned_to_id' => $normalUser->id,
        'assigned_by_id' => $admin->id,
        'title' => $task['title'],
        'description' => $task['description'],
    ]);
});

it('test that admin user create tasks and update stats job dispatched', function () {
    Queue::fake();
    $admin = User::factory()->create(['type' => UserTypeEnum::ADMIN->value]);
    $normalUser = User::factory()->create(['type' => UserTypeEnum::USER->value]);
    $task = [
        'assignee' => $normalUser->id,
        'assigner' => $admin->id,
        'title' => 'test title',
        'description' => 'test description',
    ];
    $response = $this->actingAs($admin)
        ->post('/tasks', $task);

    $response->assertStatus(302);
    Queue::assertPushed(UpdateStatistics::class);
    $this->assertDatabaseHas('tasks', [
        'assigned_to_id' => $normalUser->id,
        'assigned_by_id' => $admin->id,
        'title' => $task['title'],
        'description' => $task['description'],
    ]);
});

it('test that non admin user can not create tasks', function () {
    $admin = User::factory()->create(['type' => UserTypeEnum::ADMIN->value]);
    $normalUser = User::factory()->create(['type' => UserTypeEnum::USER->value]);
    $task = [
        'assignee' => $normalUser->id,
        'assigner' => $admin->id,
        'title' => 'test title',
        'description' => 'test description',
    ];
    $response = $this->actingAs($normalUser)
        ->post('/tasks', $task);

    $response->assertStatus(403);
    $this->assertDatabaseMissing('tasks', [
        'assigned_to_id' => $normalUser->id,
        'assigned_by_id' => $admin->id,
        'title' => $task['title'],
        'description' => $task['description'],
    ]);
});

it('test that create tasks form throws validation for required title', function () {
    $admin = User::factory()->create(['type' => UserTypeEnum::ADMIN->value]);
    $normalUser = User::factory()->create(['type' => UserTypeEnum::USER->value]);
    $task = [
        'assignee' => $normalUser->id,
        'assigner' => $admin->id,
        'title' => '',
        'description' => 'wdwqd',
    ];
    $response = $this->actingAs($admin)
        ->post('/tasks', $task);

    $response->assertStatus(302)
        ->assertInvalid(['title'])
        ->assertValid(['description', 'assignee', 'assigner']);
    $this->assertDatabaseMissing('tasks', [
        'assigned_to_id' => $normalUser->id,
        'assigned_by_id' => $admin->id,
        'title' => $task['title'],
        'description' => $task['description'],
    ]);
});

it('test that create tasks form throws validation for required description', function () {
    $admin = User::factory()->create(['type' => UserTypeEnum::ADMIN->value]);
    $normalUser = User::factory()->create(['type' => UserTypeEnum::USER->value]);
    $task = [
        'assignee' => $normalUser->id,
        'assigner' => $admin->id,
        'title' => 'wdwd',
        'description' => '',
    ];
    $response = $this->actingAs($admin)
        ->post('/tasks', $task);

    $response->assertStatus(302)
        ->assertInvalid(['description'])
        ->assertValid(['title', 'assignee', 'assigner']);
    $this->assertDatabaseMissing('tasks', [
        'assigned_to_id' => $normalUser->id,
        'assigned_by_id' => $admin->id,
        'title' => $task['title'],
        'description' => $task['description'],
    ]);
});

it('test that create tasks form throws validation for assigner must be admin', function () {
    $admin = User::factory()->create(['type' => UserTypeEnum::ADMIN->value]);
    $normalUser = User::factory()->create(['type' => UserTypeEnum::USER->value]);
    $task = [
        'assignee' => $normalUser->id,
        'assigner' => $normalUser->id,
        'title' => 'wdwd',
        'description' => 'dwdqwd',
    ];
    $response = $this->actingAs($admin)
        ->post('/tasks', $task);

    $response->assertStatus(302)
        ->assertInvalid(['assigner'])
        ->assertValid(['title', 'assignee', 'description']);
    $this->assertDatabaseMissing('tasks', [
        'assigned_to_id' => $normalUser->id,
        'assigned_by_id' => $admin->id,
        'title' => $task['title'],
        'description' => $task['description'],
    ]);
});

it('test that create tasks form throws validation for assignee must be non admin', function () {
    $admin = User::factory()->create(['type' => UserTypeEnum::ADMIN->value]);
    $normalUser = User::factory()->create(['type' => UserTypeEnum::USER->value]);
    $task = [
        'assignee' => $admin->id,
        'assigner' => $admin->id,
        'title' => 'wdwd',
        'description' => 'dwdqwd',
    ];
    $response = $this->actingAs($admin)
        ->post('/tasks', $task);

    $response->assertStatus(302)
        ->assertInvalid(['assignee'])
        ->assertValid(['title', 'assigner', 'description']);
    $this->assertDatabaseMissing('tasks', [
        'assigned_to_id' => $normalUser->id,
        'assigned_by_id' => $admin->id,
        'title' => $task['title'],
        'description' => $task['description'],
    ]);
});
