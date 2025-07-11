<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SchoolSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(RepresentantesSeeder::class);
        $this->call(PersonalDataUsersSeeder::class);
		    $this->call(ExchangeRateSeeder::class);
        $this->call(PayConfigSeeder::class);
        $this->call(BankAccountSeeder::class);
        $this->call(WalletSeeder::class);
        $this->call(BankTransactionSeeder::class);
        $this->call(PendingPaymentSeeder::class);
       
    }
}
