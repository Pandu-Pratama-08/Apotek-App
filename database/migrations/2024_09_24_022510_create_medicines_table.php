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
        Schema::create('medicines', function (Blueprint $table) {
            // PK : id -> bigInteger -> AI (auto increments)
            $table->id();
            // menambah column : $table->tipedata('nama_column')
            $table->enum('type', ['tablet', 'sirup', 'kapsul']);
            $table->string('name');
            $table->integer('price');
            $table->integer('stock');
            // membuat column created_at & updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
