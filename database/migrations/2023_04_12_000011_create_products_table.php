<?php

use App\Models\User;
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
            $table->id('product_id');
            $table->string('title', 2000);
            $table->string('slug', 2000);
            $table->longText('description')->nullable();
            // $table->foreignId('category_id')->references('category_id')->on('categories');
            $table->string('category_id')->nullable();
            $table->string('colors')->nullable();
            $table->string('sizes')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('image', 2000)->nullable();
            // $table->foreignIdFor(User::class, 'created_by')->nullable();
            // $table->foreignIdFor(User::class, 'updated_by')->nullable();
            $table->softDeletes();
            $table->foreignIdFor(User::class, 'deleted_by')->nullable();
            $table->timestamps();
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