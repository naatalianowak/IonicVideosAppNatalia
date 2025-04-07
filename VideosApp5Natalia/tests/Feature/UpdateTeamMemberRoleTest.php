<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\TeamController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTeamMemberRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_member_roles_can_be_updated()
    {
        $user = User::factory()->withPersonalTeam()->create();
        $otherUser = User::factory()->create();

        $user->currentTeam->users()->attach($otherUser, ['role' => 'admin']);

        $this->actingAs($user)
            ->put('/teams/'.$user->currentTeam->id.'/members/'.$otherUser->id, [
                'role' => 'editor',
            ]);

    }

    public function test_only_team_owner_can_update_team_member_roles()
    {
        $user = User::factory()->withPersonalTeam()->create();
        $otherUser = User::factory()->create();
        $anotherUser = User::factory()->create();

        $user->currentTeam->users()->attach($otherUser, ['role' => 'admin']);

        $this->actingAs($anotherUser)
            ->put('/teams/'.$user->currentTeam->id.'/members/'.$otherUser->id, [
                'role' => 'editor',
            ])
            ->assertStatus(403);
    }
}
