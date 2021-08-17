<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('is_active',['active','inactive']);
            $table->integer('parent')->default(0);
            $table->integer('c_order')->default(0);
            $table->string('route')->nullable();
            $table->string('icon')->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);

            $table->timestamps();
        });
        DB::unprepared(file_get_contents( __DIR__ . "/db_values.sql"));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
