<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('invoice_ref')->nullable();
            $table->string('order_amount')->nullable();
            $table->string('discount_amount')->nullable();
            $table->string('delivery_type')->nullable();
            $table->string('delivery_fee')->nullable();
            $table->enum('order_status', ['pending', 'confirmed', 'packaging', 'out_for_delivery', 'delivered', 'failed_to_deliver', 'cancelled'])->default('pending');
            $table->enum('payment_method', ['pay_at_store','cash_on_delivery', 'aba', 'wing', 'acleda'])->nullable();
            $table->enum('payment_status', ['unpaid', 'paid'])->nullable();
            $table->string('pay_slip')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
