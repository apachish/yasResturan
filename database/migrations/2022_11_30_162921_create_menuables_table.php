<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menuables', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('menuable_id');
            $table->string('menuable_type');
            $table->foreign('menu_id')
                ->references('id')
                ->on('menus')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('menuables');
    }
};
