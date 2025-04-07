<?php

namespace Tests\Unit;

use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideosTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setLocale('es');
    }

    public function test_can_get_formatted_published_at_date()
    {
        $video = Video::factory()->create([
            'published_at' => Carbon::create(2023, 1, 1, 12, 0, 0),
        ]);

        $this->assertEquals('01 de January de 2023', $video->formatted_published_at); // Comparar el formato correcto
    }

    public function test_can_get_formatted_published_at_date_when_not_published()
    {
        $video = Video::factory()->create([
            'published_at' => null,
        ]);

        $this->assertNull($video->formatted_published_at); // Verificar que si no tiene fecha, sea null
    }

    public function test_can_get_formatted_for_humans_published_at_date()
    {
        $video = Video::factory()->create([
            'published_at' => Carbon::now()->subDays(5),
        ]);

        $this->assertStringContainsString('hace', $video->formatted_for_humans_published_at); // Comprobar si el formato contiene "hace"
    }

    public function test_can_get_published_at_timestamp()
    {
        $video = Video::factory()->create([
            'published_at' => Carbon::create(2023, 1, 1, 12, 0, 0, 'UTC'),
        ]);

        $this->assertEquals(1672574400, $video->published_at_timestamp); // Comparar el timestamp
    }
}
