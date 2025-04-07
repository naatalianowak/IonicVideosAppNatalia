<?php

namespace Tests\Feature;

use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;
    protected $videoManager;
    protected $regularUser;

    public function setUp(): void
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


        \App\Helpers\PermissionHelper::setupUserManagementPermissions();

        $this->superAdmin = User::factory()->create();
        $this->superAdmin->assignRole('Super Admin');

        $this->videoManager = User::factory()->create();
        $this->videoManager->assignRole('Video Manager');

        $this->regularUser = User::factory()->create();
        $this->regularUser->assignRole('Regular User');
    }

    public function loginAsSuperAdmin()
    {
        return $this->actingAs($this->superAdmin);
    }

    public function loginAsVideoManager()
    {
        return $this->actingAs($this->videoManager);
    }

    public function loginAsRegularUser()
    {
        return $this->actingAs($this->regularUser);
    }

    public function test_user_with_permissions_can_see_add_users()
    {
        $this->loginAsSuperAdmin()
            ->get(route('users.manage.create'))
            ->assertStatus(200);
    }

    public function test_user_without_users_manage_create_cannot_see_add_users()
    {
        $this->loginAsRegularUser()
            ->get(route('users.manage.create'))
            ->assertStatus(403);
    }

    public function test_user_with_permissions_can_store_users()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $this->loginAsSuperAdmin()
            ->post(route('users.manage.store'), $userData)
            ->assertRedirect(route('users.manage.index'));

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_user_without_permissions_cannot_store_users()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $this->loginAsRegularUser()
            ->post(route('users.manage.store'), $userData)
            ->assertStatus(403);
    }

    public function test_user_with_permissions_can_destroy_users()
    {
        $targetUser = User::factory()->create();

        $this->loginAsSuperAdmin()
            ->delete(route('users.manage.destroy', $targetUser))
            ->assertRedirect(route('users.manage.index'));

        $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);
    }

    public function test_user_without_permissions_cannot_destroy_users()
    {
        $targetUser = User::factory()->create();

        $this->loginAsRegularUser()
            ->delete(route('users.manage.destroy', $targetUser))
            ->assertStatus(403);
    }

    public function test_user_with_permissions_can_see_edit_users()
    {
        $targetUser = User::factory()->create();

        $this->loginAsSuperAdmin()
            ->get(route('users.manage.edit', $targetUser))
            ->assertStatus(200);
    }

    public function test_user_without_permissions_cannot_see_edit_users()
    {
        $targetUser = User::factory()->create();

        $this->loginAsRegularUser()
            ->get(route('users.manage.edit', $targetUser))
            ->assertStatus(403);
    }

    public function test_user_with_permissions_can_update_users()
    {
        $targetUser = User::factory()->create();
        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        $this->loginAsSuperAdmin()
            ->put(route('users.manage.update', $targetUser), $updatedData)
            ->assertRedirect(route('users.manage.index'));

        $this->assertDatabaseHas('users', ['email' => 'updated@example.com']);
    }

    public function test_user_without_permissions_cannot_update_users()
    {
        $targetUser = User::factory()->create();
        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        $this->loginAsRegularUser()
            ->put(route('users.manage.update', $targetUser), $updatedData)
            ->assertStatus(403);
    }

    public function test_user_with_permissions_can_manage_users()
    {
        $this->loginAsSuperAdmin()
            ->get(route('users.manage.index'))
            ->assertStatus(200);
    }

    public function test_regular_users_cannot_manage_users()
    {
        $this->loginAsRegularUser()
            ->get(route('users.manage.index'))
            ->assertStatus(403);
    }

    public function test_guest_users_cannot_manage_users()
    {
        $this->get(route('users.manage.index'))
            ->assertRedirect(route('login'));
    }

    public function test_superadmins_can_manage_users()
    {
        $this->loginAsSuperAdmin()
            ->get(route('users.manage.index'))
            ->assertStatus(200);
    }
}
