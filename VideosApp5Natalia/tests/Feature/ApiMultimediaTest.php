<?php

namespace Tests\Feature;

use App\Models\Multimedia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiMultimediaTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_can_list_multimedia()
    {
        Multimedia::factory()->count(3)->create();

        $response = $this->getJson('/api/multimedia');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_can_create_multimedia()
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/multimedia', [
            'title' => 'Test Video',
            'file' => \Illuminate\Http\UploadedFile::fake()->create( 1000),
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'Test Video']);
    }

    public function test_can_show_multimedia()
    {
        $multimedia = Multimedia::factory()->create();

        Sanctum::actingAs($this->user);

        $response = $this->getJson("/api/multimedia/{$multimedia->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => $multimedia->title]);
    }

    public function test_can_update_multimedia()
    {
        Sanctum::actingAs($this->user);
        $multimedia = Multimedia::factory()->create(['user_id' => $this->user->id]);

        $response = $this->putJson("/api/multimedia/{$multimedia->id}", [
            'title' => 'Updated Title',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Updated Title']);
    }

    public function test_can_delete_multimedia()
    {
        Sanctum::actingAs($this->user);
        $multimedia = Multimedia::factory()->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson("/api/multimedia/{$multimedia->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Multimedia deleted']);
    }
}
