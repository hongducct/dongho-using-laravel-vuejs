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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand');
            $table->string('description');
            $table->float('price');
            $table->integer('stock');
            // $table->string('image');
            $table->timestamps();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        // Schema::table('products', function (Blueprint $table) {
        //     $table->dropForeign(['category_id'])->constrained();
        // });
    }
};
