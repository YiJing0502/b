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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->nullable()->default('')->comment('產品名稱');
            $table->integer('price')->nullable()->default(0)->comment('產品價格');
            $table->tinyInteger('public')->nullable()->default(2)->comment('產品公開1.公開/2.非公開');
            $table->string('desc')->nullable()->default('')->comment('產品描述');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
