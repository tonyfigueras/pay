<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        
        foreach ($users as $user) {
            Wallet::updateOrCreate(
                ['user_id' => $user->id],
                ['balance' => rand(1000, 100000) / 100]
            );
        }
    }
}