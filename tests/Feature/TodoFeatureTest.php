<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_todo()
    {
        $data = ['title' => 'Test Todo', 'details' => 'Test Details', 'status' => 'in_progress'];
        $response = $this->postJson('/api/todos', $data);

        $response->assertStatus(201)->assertJson($data);
        $this->assertDatabaseHas('todos', $data);
    }

    public function test_can_list_todos()
    {
        Todo::factory()->count(5)->create();

        $response = $this->getJson('/api/todos');
        $response->assertStatus(200)->assertJsonStructure(['data', 'links', 'meta']);
    }
}
