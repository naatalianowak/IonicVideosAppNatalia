<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TeamController extends Controller
{
    use AuthorizesRequests;


    /**
     * @throws AuthorizationException
     */
    public function updateRole(Request $request, Team $team, User $user): \Illuminate\Http\Response
    {
        $this->authorize('update', $team);

        $team->users()->updateExistingPivot($user->id, ['role' => $request->role]);

        return response()->noContent();
    }
}
