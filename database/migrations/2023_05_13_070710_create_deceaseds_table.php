<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deceaseds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('contactperson_id');
            $table->foreign('contactperson_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');  
        
            // $table->unsignedBigInteger('cod_id');
            // $table->foreign('cod_id')
            //     ->references('id')
            //     ->on('causeofdeaths')
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');

            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')
                ->references('id')
                ->on('addresses')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->char('causeofdeath');
            // N = Natural
            // A = Accident
            // H = Homicide
            // S = Suicide.
            // U = Undetermined
            // O = Other
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('suffix');
            //M = Male
            //F = Female
            $table->char('civilstatus');
            $table->char('sex');
            $table->date('dateof_death');
            $table->date('dateof_burial');
            $table->time('burial_time');
            $table->date('dateofbirth');

          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deceaseds');
    }
};
