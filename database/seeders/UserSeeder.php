<?php

namespace Database\Seeders;

use App\Models\PersonalDataAdmin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $personal_data = PersonalDataAdmin::create();
		
		$user = User::factory()->create([
			'username' => 'admin',
			'name' => 'Super admin',
			'privilegio' => 'A-',
			'password' => '1234',
			'actived_at' => now(),
		]);
		
		$personal_data->user()->save($user);
		
		$user->wallet()->create();
    }
}
