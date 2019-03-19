<?php

use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'name' => 'Advance Settings',
                'is_active' => 'active',
                'parent' => '0',
                'c_order' => '1',
                'route' => '',
                'icon' => 'fa fa-wrench',
                'created_by' => '1',
                'updated_by' => '1',
            ],
            [
                'name' => 'Admin Menu',
                'is_active' => 'active',
                'parent' => '1',
                'c_order' => '1',
                'route' => 'menus',
                'icon' => 'fa fa-sliders',
                'created_by' => '1',
                'updated_by' => '1',
            ],
            [
                'name' => 'Admin Menu Order',
                'is_active' => 'active',
                'parent' => '1',
                'c_order' => '2',
                'route' => 'menu_order',
                'icon' => 'fa fa-sliders',
                'created_by' => '1',
                'updated_by' => '1',
            ],
            [
                'name' => 'Role Management',
                'is_active' => 'active',
                'parent' => '1',
                'c_order' => '3',
                'route' => 'roles',
                'icon' => 'fa fa-sliders',
                'created_by' => '1',
                'updated_by' => '1',
            ],
            [
                'name' => 'Set Permission',
                'is_active' => 'active',
                'parent' => '1',
                'c_order' => '4',
                'route' => 'setpermission',
                'icon' => 'fa fa-lock',
                'created_by' => '1',
                'updated_by' => '1',
            ],
            [
                'name' => 'Users',
                'is_active' => 'active',
                'parent' => '1',
                'c_order' => '5',
                'route' => 'users',
                'icon' => 'fa fa-users',
                'created_by' => '1',
                'updated_by' => '1',
            ],
            [
                'name' => 'Dashboard',
                'is_active' => 'active',
                'parent' => '0',
                'c_order' => '0',
                'route' => 'home',
                'icon' => 'fa fa-home',
                'created_by' => '1',
                'updated_by' => '1',
            ]
        ];

        foreach($menus as $menu){
            \Ahmmed\AdminAncillary\Models\Menu::create($menu);
        }

    }
}
