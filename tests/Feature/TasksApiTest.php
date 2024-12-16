<?php

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\patchJson;
use function Pest\Laravel\postJson;

uses(WithFaker::class);

test('GET /api/tasks 200', function () {
    $user = User::factory()->create();
    actingAs($user);

    $tasks = Task::factory()->author($user)->count(3)->create();

    getJson('/api/tasks')
        ->assertStatus(200)
        ->assertJsonCount($tasks->count(), 'data');
});

test('GET /api/tasks/{task} 200', function () {
    $user = User::factory()->create();
    actingAs($user);

    $task = Task::factory()->author($user)->create();

    getJson("/api/tasks/$task->id")
        ->assertStatus(200)
        ->assertJsonPath('data.id', $task->id);
});

test('POST /api/tasks 201', function () {
    $user = User::factory()->create();
    actingAs($user);

    $data = [
        'title' => $this->faker->sentence(4),
        'description_content' => $this->faker->randomHtml(3),
        'status' => $this->faker->randomElement(TaskStatusEnum::cases()),
        'author_id' => $user->id,
        'assignee_id' => User::factory()->create()->id,
        'deadline_at' => Carbon::now()->addDays(3),
    ];

    $id = postJson('/api/tasks', $data)
        ->assertStatus(201)
        ->json('data.id');

    assertDatabaseHas(Task::class, [
        'id' => $id,
    ]);
});

test('PATCH /api/tasks/{task} 200', function () {
    $user = User::factory()->create();
    actingAs($user);

    $oldValues = [
        'title' => 'Old task title',
        'status' => TaskStatusEnum::NEW,
        'deadline_at' => null,
    ];

    $task = Task::factory()->create(['author_id' => $user->id, ...$oldValues]);

    $data = [
        'title' => 'New task title 123',
        'status' => TaskStatusEnum::IN_PROGRESS,
        'deadline_at' => Carbon::now()->addDays(4)->startOfDay(),
    ];

    $id = patchJson("/api/tasks/$task->id", $data)
        ->assertStatus(200)
        ->json('data.id');

    assertDatabaseHas(Task::class, [
        'id' => $id,
        ...$data
    ]);
});

test('DELETE /api/tasks/{task} 204', function () {
    $user = User::factory()->create();
    actingAs($user);

    $task = Task::factory()->author($user)->create();

    deleteJson("/api/tasks/$task->id")
        ->assertStatus(204);

    assertModelMissing($task);
});
