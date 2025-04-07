<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class DefaultUserHelper
{
    public static function create_regular_user(): User
    {
        $user = User::firstOrCreate(
            ['email' => 'regular@videosapp.com'],
            [
                'name' => 'Regular',
                'email' => 'regular@videosapp.com',
                'password' => Hash::make('password'),
            ]
        );
        self::add_personal_team($user);
        return $user;
    }

    public static function create_video_manager_user(): User
    {
        $user = User::firstOrCreate(
            ['email' => 'videosmanager@videosapp.com'],
            [
                'name' => 'Video Manager',
                'email' => 'videosmanager@videosapp.com',
                'password' => Hash::make('password'),
            ]
        );
        self::add_personal_team($user);
        return $user;
    }

    public static function create_superadmin_user(): User
    {
        $user = User::firstOrCreate(
            ['email' => 'superadmin@videosapp.com'],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@videosapp.com',
                'password' => Hash::make('password'),
            ]
        );
        self::add_personal_team($user);

        return $user;
    }

    public static function add_personal_team(User $user): void
    {
        $team = $user->teams()->create([
            'name' => $user->name . "'s Team",
            'personal_team' => true,
            'user_id' => $user->id,
        ]);

        $user->current_team_id = $team->id;
        $user->save();
    }

    public static function define_gates(): void
    {
        Gate::define('manage videos', function (User $user) {
            return $user->hasRole('Video Manager') || $user->hasRole('Super Admin');
        });
    }
}
