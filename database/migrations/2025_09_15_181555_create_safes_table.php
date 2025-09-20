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
        Schema::create('safes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('note');
            $table->timestamps();
        });

      DB::table('safes')->insert([
        [
          'store_id' => 1,
          'name' => 'الخزنة الرئيسية',
          'note' => '****'
        ],
        [
          'store_id' => 2,
          'name' => 'الخزنة الفرعية',
          'note' => '****'
        ],
      ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safes');
    }
};
