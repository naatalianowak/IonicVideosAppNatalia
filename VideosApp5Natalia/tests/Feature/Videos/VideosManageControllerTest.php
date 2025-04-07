<?php

namespace Tests\Feature\Videos;

use App\Models\User;
use App\Models\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Video Manager']);
        Role::create(['name' => 'Regular User']);
        Permission::create(['name' => 'view videos']);
        Permission::create(['name' => 'create videos']);
        Permission::create(['name' => 'edit videos']);
        Permission::create(['name' => 'delete videos']);
        Permission::create(['name' => 'manage videos']);
        Permission::create(['name' => 'manage users']);


        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $superAdminRole->givePermissionTo(Permission::all());

        $videoManagerRole = Role::where('name', 'Video Manager')->first();
        $videoManagerRole->givePermissionTo(['view videos', 'create videos', 'edit videos', 'delete videos', 'manage videos']);

        $regularUserRole = Role::where('name', 'Regular User')->first();
        $regularUserRole->givePermissionTo(['view videos']);
    }

    /**
     * Simula l'inici de sessió com a Video Manager.
     *
     * @return void
     */
    protected function loginAsVideoManager(): void
    {
        $user = User::factory()->create([
            'name' => 'VideoManager',
            'email' => 'videomanager@example.com',
            'password' => bcrypt('password123'), // Contrasenya: password123
        ]);
        $user->assignRole('Video Manager');
        $this->actingAs($user);
    }

    protected function loginAsSuperAdmin(): void
    {
        $user = User::factory()->create([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password123'), // Contrasenya: password123
        ]);
        $user->assignRole('Super Admin');
        $this->actingAs($user);
    }

    protected function loginAsRegularUser(): void
    {
        $user = User::factory()->create([
            'name' => 'RegularUser',
            'email' => 'regularuser@example.com',
            'password' => bcrypt('password123'), // Contrasenya: password123
        ]);
        $user->assignRole('Regular User');
        $this->actingAs($user);
    }

    /**
     * Simula el tancament de sessió.
     *
     * @return void
     */
    protected function logout(): void
    {
        auth()->logout();
    }

    /**
     * Test per verificar que un usuari amb permisos pot veure la pàgina d'addició de vídeos.
     *
     * @return void
     */
    public function test_can_see_add_videos_with_permissions()
    {
        $this->loginAsVideoManager();
        $response = $this->get(route('videos.manage.create'));
        $response->assertStatus(200);
    }

    /**
     * Test per verificar que un usuari sense permisos no pot veure la pàgina d'addició de vídeos.
     *
     * @return void
     */
    public function test_cannot_see_add_videos_without_permissions()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('videos.manage.create'));
        $response->assertStatus(403);
    }

    /**
     * Test per verificar que un usuari amb permisos pot emmagatzemar vídeos.
     *
     * @return void
     */
    public function test_can_store_videos_with_permissions()
    {
        $this->loginAsVideoManager();
        $response = $this->post(route('videos.manage.store'), [
            'title' => 'Test Video',
            'description' => 'Test Description',
            'url' => 'https://www.youtube.com/embed/test',
        ]);
        $response->assertRedirect(route('videos.manage.index'));
        $this->assertDatabaseHas('videos', ['title' => 'Test Video']);
    }

    /**
     * Test per verificar que un usuari sense permisos no pot emmagatzemar vídeos.
     *
     * @return void
     */
    public function test_cannot_store_videos_without_permissions()
    {
        $this->loginAsRegularUser();
        $response = $this->post(route('videos.manage.store'), [
            'title' => 'Test Video',
            'description' => 'Test Description',
            'url' => 'https://www.youtube.com/embed/test',
        ]);
        $response->assertStatus(403);
    }

    /**
     * Test per verificar que un usuari amb permisos pot eliminar vídeos.
     *
     * @return void
     */
    public function can_destroy_videos_with_permissions(): void
    {
        $this->loginAsVideoManager();
        $user = auth()->user();
        $video = Video::factory()->create(['user_id' => $user->id]);
        $response = $this->delete(route('videos.manage.destroy', $video->id));
        $response->assertRedirect(route('videos.manage.index'));
        $this->assertDatabaseMissing('videos', ['id' => $video->id]);
    }

    /**
     * Test per verificar que un usuari sense permisos no pot eliminar vídeos.
     *
     * @return void
     */
    public function test_cannot_destroy_videos_without_permissions()
    {
        $this->loginAsRegularUser();
        $video = Video::factory()->create();
        $response = $this->delete(route('videos.manage.destroy', $video->id));
        $response->assertStatus(403);
    }

    /**
     * Test per verificar que un usuari amb permisos pot veure la pàgina d'edició de vídeos.
     *
     * @return void
     */
    public function can_see_edit_videos_with_permissions(): void
    {
        $this->loginAsVideoManager();
        $user = auth()->user();
        $video = Video::factory()->create(['user_id' => $user->id]);
        $response = $this->get(route('videos.manage.edit', $video->id));
        $response->assertStatus(200);
    }
    /**
     * Test per verificar que un usuari sense permisos no pot veure la pàgina d'edició de vídeos.
     *
     * @return void
     */
    public function test_cannot_see_edit_videos_without_permissions()
    {
        $this->loginAsRegularUser();
        $video = Video::factory()->create();
        $response = $this->get(route('videos.manage.edit', $video->id));
        $response->assertStatus(403);
    }

    /**
     * Test per verificar que un usuari amb permisos pot actualitzar vídeos.
     *
     * @return void
     */
    public function can_update_videos_with_permissions(): void
    {
        $this->loginAsVideoManager();
        $user = auth()->user();
        $video = Video::factory()->create(['user_id' => $user->id]);
        $response = $this->put(route('videos.manage.update', $video->id), [
            'title' => 'Updated Video',
            'url' => 'https://www.youtube.com/watch?v=updated',
            'description' => 'Updated description',
        ]);
        $response->assertRedirect(route('videos.manage.index'));
        $this->assertDatabaseHas('videos', ['title' => 'Updated Video']);
    }

    /**
     * Test per verificar que un usuari sense permisos no pot actualitzar vídeos.
     *
     * @return void
     */
    public function test_cannot_update_videos_without_permissions()
    {
        $this->loginAsRegularUser();
        $video = Video::factory()->create();
        $response = $this->put(route('videos.manage.update', $video->id), [
            'title' => 'Updated Video',
            'description' => 'Updated Description',
            'url' => 'https://www.youtube.com/embed/updated',
        ]);
        $response->assertStatus(403);
    }

    /**
     * Test per verificar que un usuari amb permisos pot gestionar vídeos.
     *
     * @return void
     */
    public function can_manage_videos_with_permissions()
    {
        Permission::firstOrCreate(['name' => 'manage videos']);
        $role = Role::firstOrCreate(['name' => 'Video Manager']);
        $role->givePermissionTo('manage videos');

        $user = User::factory()->create();
        $user->assignRole('Video Manager');

        Video::factory()->count(3)->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->get(route('videos.manage.index'));

        $response->assertStatus(200);
        $response->assertViewHas('videos');
        $this->assertEquals(3, $response->original->getData()['videos']->count());
    }

    /**
     * Test per verificar que els usuaris regulars no poden gestionar vídeos.
     *
     * @return void
     */
    public function test_cannot_manage_videos_as_regular_user()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('videos.manage.index'));
        $response->assertStatus(403);
    }

    /**
     * Test per verificar que els usuaris convidats no poden gestionar vídeos.
     *
     * @return void
     */
    public function test_cannot_manage_videos_as_guest()
    {
        $this->logout();
        $response = $this->get(route('videos.manage.index'));
        $response->assertRedirect(); // Redirecció a login (estat 302 típicament)
    }

    /**
     * Test per verificar que els superadmins poden gestionar vídeos.
     *
     * @return void
     */
    public function test_can_manage_videos_as_superadmin()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('videos.manage.index'));
        $response->assertStatus(200);
        $response->assertViewHas('videos');
    }
}
