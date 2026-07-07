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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->change();
            $table->foreign('type_id')->references('id')->on('types');
        });

        Schema::table('products_in_baskets', function (Blueprint $table) {
            $table->unsignedBigInteger('basket_id')->change();
            $table->unsignedBigInteger('product_id')->change();
            $table->foreign('basket_id')->references('id')->on('baskets');
            $table->foreign('product_id')->references('id')->on('products');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('basket_id')->change();
            $table->unsignedBigInteger('status_id')->default(1)->change();
            $table->foreign('basket_id')->references('id')->on('baskets');
            $table->foreign('status_id')->references('id')->on('statuses');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->change();
            $table->foreign('status_id')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
        });

        Schema::table('products_in_baskets', function (Blueprint $table) {
            $table->dropForeign(['basket_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['basket_id']);
            $table->dropForeign(['status_id']);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
        });
    }
};
