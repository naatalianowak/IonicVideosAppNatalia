<?php

namespace Database\Seeders;

use App\Helpers\PermissionHelper;
use App\Models\Video;
use Illuminate\Database\Seeder;
use App\Helpers\DefaultUserHelper;
use App\Helpers\DefaultVideoHelper;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'view videos']);
        Permission::firstOrCreate(['name' => 'create videos']);
        Permission::firstOrCreate(['name' => 'manage videos']);


        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdminRole->givePermissionTo(Permission::all());
        $superAdminRole->syncPermissions(Permission::all());

        $videoManagerRole = Role::firstOrCreate(['name' => 'Video Manager']);
        $videoManagerRole->givePermissionTo(['view videos', 'create videos', 'manage videos']);
        $videoManagerRole->syncPermissions(['view videos', 'create videos', 'manage videos']);

        $regularUserRole = Role::firstOrCreate(['name' => 'Regular User']);
        $regularUserRole->givePermissionTo(['view videos']);
        $regularUserRole->syncPermissions(['view videos']);

        $superAdmin = DefaultUserHelper::create_superadmin_user();
       // $superAdmin->assignRole($superAdminRole);

        $videoManager = DefaultUserHelper::create_video_manager_user();
        //$videoManager->assignRole($videoManagerRole);

        $regularUser = DefaultUserHelper::create_regular_user();

        //$regularUser->assignRole($regularUserRole);


        PermissionHelper::setupVideoPermissions();


        if (Video::count() === 0) {
            DefaultVideoHelper::createDefaultVideos();
        }


    }
}

