<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PayConfig;

class PayConfigSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Pagos
		$user = PayConfig::create([
			'name' => 'gc_mensualidad',
			'value' => 4,
		]);

		$user = PayConfig::create([
			'name' => 'gc_inscripción',
			'value' => 2,
		]);
	}
}
