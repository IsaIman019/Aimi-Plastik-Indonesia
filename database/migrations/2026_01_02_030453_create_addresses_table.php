<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('label')->default('Rumah'); // Contoh: Rumah, Kantor
            $table->string('recipient_name'); // Nama Penerima
            $table->string('phone'); // No HP Penerima
            $table->text('full_address'); // Alamat Lengkap
            $table->boolean('is_primary')->default(false); // Alamat Utama?
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};