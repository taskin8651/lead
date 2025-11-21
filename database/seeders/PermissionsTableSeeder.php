<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'leads_module_create',
            ],
            [
                'id'    => 20,
                'title' => 'leads_module_edit',
            ],
            [
                'id'    => 21,
                'title' => 'leads_module_show',
            ],
            [
                'id'    => 22,
                'title' => 'leads_module_delete',
            ],
            [
                'id'    => 23,
                'title' => 'leads_module_access',
            ],
            [
                'id'    => 24,
                'title' => 'service_create',
            ],
            [
                'id'    => 25,
                'title' => 'service_edit',
            ],
            [
                'id'    => 26,
                'title' => 'service_show',
            ],
            [
                'id'    => 27,
                'title' => 'service_delete',
            ],
            [
                'id'    => 28,
                'title' => 'service_access',
            ],
            [
                'id'    => 29,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
