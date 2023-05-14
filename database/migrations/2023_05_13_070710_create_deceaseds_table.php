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

            $table->unsignedBigInteger('nationality_id');
            $table->foreign('nationality_id')
                ->references('id')
                ->on('nationalities')
                ->onUpdate('cascade')
                ->onDelete('cascade');  
        
            $table->unsignedBigInteger('cod_id');
            $table->foreign('cod_id')
                ->references('id')
                ->on('causeofdeaths')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')
                ->references('id')
                ->on('addresses')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename');
            $table->date('dateof_death');
            $table->date('dateofbirth');

            //1 = Male
            //2 = Female
            $table->tinyInteger('civilstatus')->default(0);
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
