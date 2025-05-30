<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Ubah kolom delivery_date menjadi timestampTz (timestamp with timezone)
            $table->timestampTz('delivery_date')->nullable()->change();
        });
    }
};