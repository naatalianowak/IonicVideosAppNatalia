<?php

namespace Tests\Unit;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

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
    }

    public function test_is_super_admin()
    {
        $user = User::factory()->create(['is_superadmin' => true]);
        $user->assignRole('Super Admin');

        $this->assertTrue($user->isSuperAdmin());
    }

    public function test_user_without_permissions_can_see_default_users_page()
    {
        $user = User::factory()->create();
        $user->assignRole('Regular User');

        $this->actingAs($user)
            ->get(route('users.index'))
            ->assertStatus(200);
    }

    public function test_user_with_permissions_can_see_default_users_page()
    {
        $user = User::factory()->create();
        $user->assignRole('Super Admin');

        $this->actingAs($user)
            ->get(route('users.index'))
            ->assertStatus(200);
    }

    public function test_not_logged_users_cannot_see_default_users_page()
    {
        $this->get(route('users.index'))
            ->assertRedirect(route('login'));
    }

    public function test_user_without_permissions_can_see_user_show_page()
    {
        $user = User::factory()->create();
        $user->assignRole('Regular User');
        $targetUser = User::factory()->create();

        $this->actingAs($user)
            ->get(route('users.show', $targetUser))
            ->assertStatus(200);
    }

    public function test_user_with_permissions_can_see_user_show_page()
    {
        $user = User::factory()->create();
        $user->assignRole('Super Admin');
        $targetUser = User::factory()->create();

        $this->actingAs($user)
            ->get(route('users.show', $targetUser))
            ->assertStatus(200);
    }

    public function test_not_logged_users_cannot_see_user_show_page()
    {
        $targetUser = User::factory()->create();

        $this->get(route('users.show', $targetUser))
            ->assertRedirect(route('login'));
    }
}
