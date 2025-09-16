<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('barcode')->unique();
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->string('unit')->default('piece');
            $table->timestamps();
        });
        
        DB::table('products')->insert([
          [
            'name' => 'عصير فراجلو',
            'barcode' => '100',
            'purchase_price' => 100,
            'sale_price' => 120,
          ],
          [
            'name' => 'بسكويت سادة',
            'barcode' => '101',
            'purchase_price' => 50.75,
            'sale_price' => 60,
          ],
          [
            'name' => 'بن عبدالمعبود',
            'barcode' => '102',
            'purchase_price' => 650,
            'sale_price' => 900,
          ],
          [
            'name' => 'لبن بخيرة',
            'barcode' => '103',
            'purchase_price' => 65,
            'sale_price' => 70.75,
          ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
