<?php

use App\Models\Product;
use App\Models\Purchase;
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
        Schema::create('product_purchase', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Purchase::class)
                ->constrained();
            $table->foreignIdFor(Product::class)
                ->constrained();
            $table->integer('amount')
                ->default(0);
            $table->integer('price')
                ->default(0)
                ->comment('Unit price for the product');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_purchase');
    }
};
