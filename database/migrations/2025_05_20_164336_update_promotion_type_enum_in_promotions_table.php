<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::statement("ALTER TABLE promotions MODIFY COLUMN promotion_type ENUM('category', 'product') NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Optional: revert back to the old enum values
        DB::statement("ALTER TABLE promotions MODIFY COLUMN promotion_type ENUM('brand', 'product') NULL");
    }
};
