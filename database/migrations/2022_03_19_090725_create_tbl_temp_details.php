<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblTempDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblTempDetails', function (Blueprint $table) {
            $table->id();
            $table->float('city_1_temp_fahrenheit', 5, 2);
            $table->float('city_1_temp_celsius', 5, 2);
            $table->float('city_2_temp_fahrenheit', 5, 2);
            $table->float('city_2_temp_celsius', 5, 2);
            $table->integer('userId');
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
        Schema::dropIfExists('tbl_temp_details');
    }
}
