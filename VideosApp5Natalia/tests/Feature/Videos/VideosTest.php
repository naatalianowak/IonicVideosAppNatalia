<?php

namespace Tests\Feature\Videos;

use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class VideosTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test para verificar que los usuarios pueden ver videos existentes.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $permissions = [
            'manage videos', 'create videos', 'edit videos', 'delete videos',
            'manage users', 'create users', 'edit users', 'delete users'
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $role = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $role->syncPermissions($permissions);

        $this->user = User::factory()->create([
            'email' => 'superadmin@videosapp.com',
            'password' => bcrypt('password123'),
        ]);
        $this->user->assignRole('Super Admin');
    }

    public function test_users_can_view_videos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $video = Video::factory()->create();

        $response = $this->get(route('videos.show', $video->id));

        $response->assertStatus(200);
        $response->assertViewIs('videos.show');
        $response->assertViewHas('video', $video);
    }

    /**
     * Test para verificar que los usuarios no pueden ver videos inexistentes.
     *
     * @return void
     */
    public function test_users_cannot_view_not_existing_videos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $nonExistentVideoId = 999;

        $response = $this->get(route('videos.show', $nonExistentVideoId));

        $response->assertStatus(404);
    }

    /**
     * Test para verificar que un usuario sin permisos puede ver la página predeterminada de videos.
     *
     * @return void
     */
    public function test_user_without_permissions_can_see_default_videos_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Video::factory()->count(3)->create();

        $response = $this->get(route('videos.index'));

        $response->assertStatus(200);
        $response->assertViewIs('videos.index');
        $response->assertViewHas('videos');
    }

    /**
     * Test para verificar que un usuario con permisos puede ver la página predeterminada de videos.
     *
     * @return void
     */
    public function test_user_with_permissions_can_see_default_videos_page()
    {
        $user = User::factory()->create();
        $role = Role::firstOrCreate(['name' => 'Regular User']);
        $user->assignRole($role);

        Video::factory()->count(3)->create();

        $this->actingAs($user);

        $response = $this->get(route('videos.index'));

        $response->assertStatus(200);
        $response->assertViewIs('videos.index');
        $response->assertViewHas('videos');
    }

    /**
     * Test para verificar que un usuario no logueado puede ver la página predeterminada de videos.
     *
     * @return void
     */
    public function test_not_logged_users_can_see_default_videos_page()
    {
        Video::factory()->count(3)->create();

        $response = $this->get(route('videos.index'));

        $response->assertStatus(200);
        $response->assertViewIs('videos.index');
        $response->assertViewHas('videos');
    }

    public function test_videos_index_page_can_be_viewed()
    {
        // Utilitza el superadmin creat al seeder
        $user = User::where('email', 'superadmin@videosapp.com')->first();
        $this->actingAs($user);

        $response = $this->get(route('videos.index'));

        $response->assertStatus(200);
        $response->assertViewIs('videos.index');
    }
}
