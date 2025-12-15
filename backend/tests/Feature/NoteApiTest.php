<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_note()
    {
        $response = $this->postJson('/api/notes', [
            'title' => 'Nota de test',
            'content' => 'Contenido de prueba',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data' => [
                         'id',
                         'title',
                         'content',
                         'created_at',
                         'updated_at',
                     ],
                 ]);

        $this->assertDatabaseHas('notes', [
            'title' => 'Nota de test',
        ]);
    }

    /** @test */
    public function title_is_required()
    {
        $response = $this->postJson('/api/notes', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('title');
    }
}
