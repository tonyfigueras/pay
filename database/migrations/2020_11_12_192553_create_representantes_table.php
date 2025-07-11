<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepresentantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('representantes', function (Blueprint $table) {
            $table->id();
            
            // Datos personales
            $table->string("nombre");
            $table->enum("nacionalidad", ['V', 'E']);
            $table->bigInteger('cedula')->unique();
            $table->bigInteger('telefono');
            $table->string('direccion');
            $table->enum("sexo", ['Masculino', 'Femenino']);
            
            // Tipo de familiar
            $table->enum("tipo_familiar", [
                'Madre', 
                'Padre',
                'Abuela(o)',
                'Padrastro',
                'Madastra',
                'Tia(o)',
                'Otro'
            ]);
            
            // Estado civil
            $table->enum("estado_civil", [
                'Soltero', 
                'Casado',
                'Viudo',
                'Concubino',
                'Divorciado',
            ]);
            
            // Datos de nacimiento
            $table->date("nacimiento");
            $table->string("email")->nullable();
            
            // Ubicación
            $table->char("ubi_estado", 30);
            $table->string("ubi_municipio");
            $table->string("ubi_parroquia");
            $table->enum("ubi_via", [
                'Aut', 
                'Av',
                'Blvr',
                'Calle',
                'Callejón',
                'Carretera',
                'Manzana',
                'Prolongación',
                'Transversal',
                'Vereda',
            ]);
            
            // Datos laborales
            $table->enum("empleo", ['Si', 'No']);
            $table->string("empleo_profesion")->nullable();
            $table->string("empleo_lugar")->nullable();
            
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
        Schema::dropIfExists('representantes');
    }
}