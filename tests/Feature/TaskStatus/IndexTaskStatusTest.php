<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTaskStatusTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $this->seed();
        $response = $this->get('/task_statuses');
        $response->assertSee('sasha');
        $response->assertStatus(200);
    }
}
