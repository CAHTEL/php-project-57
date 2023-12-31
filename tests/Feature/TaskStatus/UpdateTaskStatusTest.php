<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UpdateTaskStatusTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateTaskStatusUserValid(): void
    {
        $this->seed();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->patch(route('task_statuses.update', 10), ['name' => 'Aslan']);
        $response->assertRedirect('/task_statuses');
        $response->assertValid();
        $this->assertDatabaseHas('task_statuses', [
            'name' => 'Aslan'
        ]);
    }

    public function testUpdateTaskStatusUserInvalid(): void
    {
        $this->seed();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->patch(route('task_statuses.update', 10), ['name' => 'sasha']);
        $response->assertInvalid(['name']);
    }

    public function testUpdateTaskStatusGuest(): void
    {
        $this->seed();
        $response = $this->patch(route('task_statuses.update', 10));
        $response->assertStatus(403);
    }
}
