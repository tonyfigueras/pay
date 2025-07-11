<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalDataUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('personal_data_users', function (Blueprint $table) {
			$table->id();
			
			   // Datos personales
            $table->string("estudi_nombre");
			$table->enum("estudi_cedulado", ['Si', 'No'])->nullable()->default(null);
            $table->enum("estudi_nacionalidad", ['V', 'E']);
            $table->bigInteger('cedula')->nullable();
			// RELACIÓN CON REPRESENTANTE 
            $table->foreignId('representante_id')
                ->nullable()
                ->constrained('representantes')
                ->onDelete('set null');
			
			/*
				ESTUDIANTE
			*/
			$table->enum("estudi_sexo", ['Masculino', 'Femenino'])->nullable()->default(null);
			$table->enum("estudi_lateralidad", [
				'Derecho', 
				'Zurdo',
				'Ambidiestro',
			])->nullable()->default(null);
			$table->date("estudi_nacimiento")->nullable()->default(null);
			$table->char("estudi_nacimiento_estado", 30)->nullable()->default(null);
			$table->string("estudi_nacimiento_lugar")->nullable()->default(null);
			$table->enum("estudi_ubi", [
				'Barrio',
				'Caserio',
				'Urbanización',
				'Zona residencial',
				'Otros',
			])->nullable()->default(null);
			$table->enum("estudi_ubi_tipo", [
				'Apto',
				'Apto-quinta',
				'Casa',
				'Casa-quinta',
				'Quinta',
				'Rancho barrio',
				'Refugio',
				'Casa de vecindad',
				'Improvisado',
				'Rancho rural'
			])->nullable()->default(null);
			$table->enum("estudi_ubi_zona", [
				'Rural',
				'Urbana',
			])->nullable()->default(null);
			$table->enum("estudi_ubi_condiInfra", [
				1,2,3,4,5
			])->nullable()->default(null);
			$table->enum("estudi_ubi_condiVivienda", [
				'Al cuido',
				'Alquilada',
				'Propia pagada',
				'Propia pagandose',
				'Otro',
			])->nullable()->default(null);
			$table->enum("estudi_otros_canaima", [
				'Si',
				'No',
			])->nullable()->default(null);
			$table->enum("estudi_otros_beca", [
				'Si',
				'No',
			])->nullable()->default(null);
			$table->enum("estudi_otros_alojado", [
				'Si',
				'No',
			])->nullable()->default(null);
			$table->string("estudi_otros_direccion")->nullable()->default(null);
			
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('personal_data_users');
	}
}
