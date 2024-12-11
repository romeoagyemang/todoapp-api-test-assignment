<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class TodoTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_todo_creation()
    {
        $todo = Todo::factory()->create();
        $this->assertDatabaseHas('todos', ['id' => $todo->id]);
    }
}
