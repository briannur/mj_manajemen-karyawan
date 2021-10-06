<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ManagemenKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string('office_name');
            $table->integer('capacity');
            $table->timestamps();
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->integer('desk');
            $table->string('name');
            $table->string('univ');
            $table->string('shift');
            $table->string('office');
            $table->string('status');
            $table->date('start');
            $table->date('end');
            $table->timestamps();
        });

        Schema::create('admincalls', function (Blueprint $table) {
            $table->id();
            $table->string('password');
            $table->string('office_name');
            $table->integer('capacity');
            $table->timestamps();
        });

        Schema::create('usercalls', function (Blueprint $table) {
            $table->id();
            $table->string('office_name');
            $table->integer('capacity');
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
        Schema::dropIfExists('offices');
        Schema::dropIfExists('employees');
    }
}
