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
            $table->bigIncrements('id');
            $table->string('reference_cod', 50)->nullable();
            $table->string('customer_name',80);
            $table->string('customer_email',120);
            $table->string('customer_mobile',40);
            $table->integer('request_id')->nullable();
            $table->string('response_mess')->nullable();
            $table->string('process_url')->nullable();
            $table->string('status', 10)->nullable();
            $table->unsignedBigInteger('id_client')->comment('Relación con la tabla clients.');
            $table->unsignedBigInteger('id_product')->comment('Relación con la tabla products.');
            $table->timestamps();
            $table->foreign('id_client')->references('id')->on('clients')->onUpdate('cascade');
            $table->foreign('id_product')->references('id')->on('products')->onUpdate('cascade');
			$table->decimal('product_cost', 8, 2)->comment('Costo en el instante de compra.');
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
