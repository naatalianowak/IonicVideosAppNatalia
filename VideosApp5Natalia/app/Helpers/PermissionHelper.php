<?php

namespace App\Helpers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionHelper
{
    /**
     * Inicialitza els permisos de vídeos i els assigna als rols.
     *
     * @return void
     */
    public static function setupVideoPermissions(): void
    {
        $permissions = [
            'view videos',
            'create videos',
            'edit videos',
            'delete videos',
            'manage videos',
        ];
        $permissions = array_merge($permissions, [
            'view multimedia',
            'create multimedia',
            'update multimedia',
            'delete multimedia',
            'manage multimedia',
        ]);

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdminRole->givePermissionTo(Permission::all());
        $videoManagerRole = Role::firstOrCreate(['name' => 'Video Manager']);
        $videoManagerRole->givePermissionTo([
            'view videos',
            'create videos',
            'edit videos',
            'delete videos',
            'manage videos',
            'view multimedia',
            'create multimedia',
            'update multimedia',
            'delete multimedia',
            'manage multimedia',
        ]);
        $regularUserRole = Role::firstOrCreate(['name' => 'Regular User']);
        $regularUserRole->givePermissionTo(['view videos', 'view multimedia', 'create multimedia']);

        $superAdminRole->syncPermissions($permissions);
        $videoManagerRole->syncPermissions(['view videos', 'create videos', 'edit videos', 'delete videos', 'manage videos']);
        $regularUserRole->syncPermissions(['view videos']);
    }
    public static function setupUserManagementPermissions()
    {
        $permissions = [
            'manage users',
            'create users',
            'edit users',
            'delete users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }


        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdminRole->syncPermissions($permissions);

        $otherRoles = Role::whereNotIn('name', ['Super Admin'])->get();
        foreach ($otherRoles as $role) {
            $role->revokePermissionTo($permissions);
        }
    }
}
