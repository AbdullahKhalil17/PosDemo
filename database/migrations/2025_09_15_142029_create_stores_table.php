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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->timestamps();
        });


        DB::table('stores')->insert([
          [
            'name' => 'فرع شبرا الخيمة',
            'address' => 'شبرا الخيمة ثان القليوبية'
          ],
          [
            'name' => 'فرع سرايا القبة',
            'address' => 'سرايا القبة القليوبية'
          ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
