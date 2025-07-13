<?php

namespace Database\Seeders;

use App\Models\CurrentLocation;
use App\Models\Product;
use App\Models\UserCustomization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // student management
        Permission::create(['name' => 'Add student']);
        Permission::create(['name' => 'Deactivate student']);
        Permission::create(['name' => 'Remove student']);

        // professor management
        Permission::create(['name' => 'Add professor']);
        Permission::create(['name' => 'Deactivate professor']);
        Permission::create(['name' => 'Remove professor']);

        // school management
        Permission::create(['name' => 'Create school']);
        Permission::create(['name' => 'Disable school']);
        Permission::create(['name' => 'Delete school']);

        // course management
        Permission::create(['name' => 'Create course']);
        Permission::create(['name' => 'Edit course']);
        Permission::create(['name' => 'Remove course']);
        Permission::create(['name' => 'Disable course']);

        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        $adminRole = Role::create(['name' => 'admin'])
            ->givePermissionTo([
                'Add student',
                'Deactivate student',
                'Remove student',
                'Add professor',
                'Deactivate professor',
                'Remove professor',
                'Create school',
                'Disable school',
                'Delete school',
                'Create course',
                'Edit course',
                'Remove course',
                'Disable course'
            ]);

        $professorRole = Role::create(['name' => 'professor'])
            ->givePermissionTo([
                'Add student',
                'Deactivate student',
                'Remove student',
            ]);

        $studentRole = Role::create(['name' => 'student'])
            ->givePermissionTo([

            ]);

        $superadmin = \App\Models\User::factory()->create([
            'name' => 'Daniel L.',
            'username' => 'daniel',
            'email' => 'dlogvinkir@gmail.com',
            'password' => bcrypt('3!5R_)sT#,HkT:C5'),
        ]);

        $superadmin->assignRole($superAdminRole);

        $student = \App\Models\User::factory()->create([
            'name' => 'Jocelyn L.',
            'username' => 'jocelyn',
            'email' => 'jocelyn@utsubo.com',
            'password' => bcrypt('Student1$'),
        ]);

        $student->assignRole($studentRole);

        $professor = \App\Models\User::factory()->create([
            'name' => 'Jocelyn L.',
            'username' => 'jocelyn-professor',
            'email' => 'jocelyn-professor@utsubo.com',
            'password' => bcrypt('Professor1$'),
        ]);

        $professor->assignRole($professorRole);

        $categories = [
            'accessory' => [
                'wrist_strasp', 'hand_glove', 'BackPack_1', 'BackPack_2',
                'BoxeGloves', 'Gloves', 'KneePads', 'Medal_1', 'Medal_2'
            ],
            'head_accessory' => [
                'Bandana', 'BeeHelmet', 'BoxeHelmet', 'Glasses', 'Goggles',
                'GreenGlasses', 'Hat', 'HeadPhone_1', 'HeadPhone_2', 'Helmet', 'SunHat'
            ],
            'bottom' => [
                'bottom_pants', 'bottom_pants1', 'bottom_pants2', 'bottom_pants3',
                'bottom_pants4', 'bottom_pants5', 'bottom_pants6', 'bottom_pants7',
                'bottom_pants8', 'bottom_pants9', 'bottom_pants10'
            ],
            'top' => [
                'top_shirt', 'top_shirt1', 'top_shirt2', 'top_shirt3', 'top_shirt4',
                'top_shirt5', 'top_shirt6', 'top_shirt7', 'top_shirt8', 'top_shirt9', 'top_shirt10'
            ],
            'shoe' => [
                'shoes_sport', 'shoes_sport1', 'shoes_sport2', 'shoes_sport3',
                'shoes_sport4', 'shoes_sport5', 'shoes_sport6', 'shoes_sport7', 'shoes_sport8'
            ],
            'hair' => [
                'hair_short'
            ],
        ];

        foreach ($categories as $type => $products) {
            $selectedProducts = array_slice($products, 0, 2); // Take the first 2 products of each category
            foreach ($selectedProducts as $index => $productName) {
                $product = Product::create([
                    'name' => $productName,
                    'type' => $type,
                    'price' => rand(10, 50),
                ]);

                // Assign the product to the user
                $student->products()->attach($product->id, [
                    'is_active' => $index === 0 ? true : false, // Activate only the first product of each category
                ]);
            }
        }

        CurrentLocation::create([
           'user_id' => $student->id,
           'galaxy_id' => '1',
           'world_id' => '1',
           'x' => 0,
           'y' => 0,
           'z' => 0,
        ]);

        UserCustomization::create([
           'user_id' => $student->id,
           'skin_color' => '#F5F5B0',
            'hair_color' => '#E6CEA8',
            'eyes_color' => '#634E34'
        ]);
    }
}
