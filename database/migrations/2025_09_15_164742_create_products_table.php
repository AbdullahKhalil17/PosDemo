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
            $table->decimal('purchase_price', 12, 2);
            $table->decimal('sale_price', 12, 2);
            $table->string('unit')->default('piece');
            $table->timestamps();
        });
        
        DB::table('products')->insert([
        [
            'name' => 'عصير فراجلو',
            'barcode' => '100',
            'purchase_price' => 100.85,
            'sale_price' => 120.75,
        ],
        [
            'name' => 'بسكويت سادة',
            'barcode' => '101',
            'purchase_price' => 50.75,
            'sale_price' => 60.30,
        ],
        [
            'name' => 'بن عبدالمعبود',
            'barcode' => '102',
            'purchase_price' => 655.55,
            'sale_price' => 900.10,
        ],
        [
            'name' => 'لبن بخيرة',
            'barcode' => '103',
            'purchase_price' => 65.47,
            'sale_price' => 70.75,
        ],
        [
            'name' => 'شاي كرك',
            'barcode' => '104',
            'purchase_price' => 40.30,
            'sale_price' => 50.93,
        ],
        [
            'name' => 'تمر خلاص',
            'barcode' => '105',
            'purchase_price' => 200.35,
            'sale_price' => 250.45,
        ],
        [
            'name' => 'ماء معدني',
            'barcode' => '106',
            'purchase_price' => 10.30,
            'sale_price' => 15.5,
        ],
        [
            'name' => 'عصير برتقال',
            'barcode' => '107',
            'purchase_price' => 90.10,
            'sale_price' => 110.31,
        ],
        [
            'name' => 'شوكولاتة كيت كات',
            'barcode' => '108',
            'purchase_price' => 30.35,
            'sale_price' => 40.45,
        ],
        [
            'name' => 'جبنة قريش',
            'barcode' => '109',
            'purchase_price' => 25.23,
            'sale_price' => 35.32,
        ],
        [
            'name' => 'مكرونة سباجيتي',
            'barcode' => '110',
            'purchase_price' => 15.35,
            'sale_price' => 25.31,
        ],
        [
            'name' => 'أرز مصري',
            'barcode' => '111',
            'purchase_price' => 35.30,
            'sale_price' => 45.70,
        ],
        [
            'name' => 'زيت عباد الشمس',
            'barcode' => '112',
            'purchase_price' => 120.30,
            'sale_price' => 150.56,
        ],
        [
            'name' => 'سكر أبيض',
            'barcode' => '113',
            'purchase_price' => 20.30,
            'sale_price' => 25.20,
        ],
        [
            'name' => 'ملح الطعام',
            'barcode' => '114',
            'purchase_price' => 5.45,
            'sale_price' => 6.50,
        ],
        [
            'name' => 'شوربة دجاج',
            'barcode' => '115',
            'purchase_price' => 50,
            'sale_price' => 60,
        ],
        [
            'name' => 'صلصة طماطم',
            'barcode' => '116',
            'purchase_price' => 15,
            'sale_price' => 25,
        ],
        [
            'name' => 'زبادي طبيعي',
            'barcode' => '117',
            'purchase_price' => 20,
            'sale_price' => 30,
        ],
        [
            'name' => 'حليب طويل الأجل',
            'barcode' => '118',
            'purchase_price' => 25,
            'sale_price' => 35,
        ],
        [
            'name' => 'عسل طبيعي',
            'barcode' => '119',
            'purchase_price' => 80,
            'sale_price' => 100,
        ],
        [
            'name' => 'فول مدمس',
            'barcode' => '120',
            'purchase_price' => 30,
            'sale_price' => 40,
        ],
        [
            'name' => 'عدس أصفر',
            'barcode' => '121',
            'purchase_price' => 25,
            'sale_price' => 35,
        ],
        [
            'name' => 'حمص',
            'barcode' => '122',
            'purchase_price' => 20,
            'sale_price' => 30,
        ],
        [
            'name' => 'بسطرمة',
            'barcode' => '123',
            'purchase_price' => 150,
            'sale_price' => 180,
        ],
        [
            'name' => 'سجق إيطالي',
            'barcode' => '124',
            'purchase_price' => 120,
            'sale_price' => 150,
        ],
        [
            'name' => 'زبدة بلدي',
            'barcode' => '125',
            'purchase_price' => 60,
            'sale_price' => 80,
        ],
        [
            'name' => 'بيض أبيض',
            'barcode' => '126',
            'purchase_price' => 10,
            'sale_price' => 15,
        ],
        [
            'name' => 'دقيق أبيض',
            'barcode' => '127',
            'purchase_price' => 20,
            'sale_price' => 30,
        ],
        [
            'name' => 'شاي أخضر',
            'barcode' => '128',
            'purchase_price' => 60,
            'sale_price' => 80,
        ],
        [
            'name' => 'قهوة سريعة التحضير',
            'barcode' => '129',
            'purchase_price' => 70,
            'sale_price' => 90,
        ],
        [
            'name' => 'عصير مانجو',
            'barcode' => '130',
            'purchase_price' => 100,
            'sale_price' => 120,
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
