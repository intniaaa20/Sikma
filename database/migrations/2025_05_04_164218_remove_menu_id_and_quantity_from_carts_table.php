<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn(['menu_id', 'quantity']);
        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_id')->nullable();
            $table->integer('quantity')->nullable();
        });
    }
};
