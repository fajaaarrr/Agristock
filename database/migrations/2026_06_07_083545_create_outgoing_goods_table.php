<?php

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
        Schema::create('outgoing_goods', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi')->unique();
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->date('tanggal_keluar');
            $table->integer('jumlah');
            $table->string('tujuan_penggunaan');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_goods');
    }
};
