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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('author_id')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('pages')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('reviews')->nullable();
            $table->string('format')->nullable();
            $table->string('barcode')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('author_id');
            $table->dropColumn('price');
            $table->dropColumn('pages');
            $table->dropColumn('thumbnail');
            $table->dropColumn('reviews');
            $table->dropColumn('format');
            $table->dropColumn('barcode');
        });
    }
};
