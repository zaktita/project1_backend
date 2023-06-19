<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use app\Models\User;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payements', function (Blueprint $table) {
            $table->id('payement_id');
            $table->foreignId('order_id')->references('order_id')->on('orders');
            $table->decimal('amount',10);
            $table->string('type',45);
            $table->foreignIdFor(user::class,'created_by')->nullable();
            $table->foreignIdFor(user::class,'updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payements');
    }
};
