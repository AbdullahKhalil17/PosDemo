<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'cashier'])->default('cashier');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
          [
            'name' => 'Abdullah',
            'email' => 'k.goma959@gmail.com',
            'password' => Hash::make(123456),
            'role' => 'admin'
          ],
          [
            'name' => 'mohamed',
            'email' => 'mohamed@gmail.com',
            'password' => Hash::make(123456),
            'role' => 'cashier',
          ],
          [
            'name' => 'mahmoud',
            'email' => 'mahmoud@gmail.com',
            'password' => Hash::make(123456),
            'role' => 'cashier',
          ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
