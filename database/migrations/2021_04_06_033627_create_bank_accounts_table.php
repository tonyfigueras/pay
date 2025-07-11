<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bank_accounts', function (Blueprint $table) {
			$table->id();
			$table->char('n_account', 25)->unique();
			$table->char('rif', 25);
			$table->string('name', 100);
			$table->string('email', 100);
			$table->enum('type', ['ahorro', 'corriente']);
			$table->char('code', 4);
			 $table->foreignId('school_id')->constrained()->cascadeOnDelete();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('bank_accounts');
	}
}
