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
        Schema::create('analisa_on_farms', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor_core')->nullable();
            $table->tinyInteger('nomor_ari')->nullable();
            $table->string('spta', 8)->nullable();
            $table->string('kartu_core', 10)->nullable();
            $table->float('brix_posbrix')->nullable();
            $table->longText('bukti_posbrix')->nullable();
            $table->longText('bukti_truk_posbrix')->nullable();

            $table->foreignId('variety_id')->nullable()->constrained();
            $table->foreignId('kawalan_id')->nullable()->constrained();

            $table->string('status', 20)->nullable();
            $table->string('kartu_ari', 10)->nullable();
            $table->string('kartu_masuk', 10)->nullable();
            $table->string('nomor_antrian', 9)->nullable()->unique();
            $table->string('register', 8)->nullable();
            $table->string('nopol', 10)->nullable();
            $table->string('petani', 100)->nullable();

            $table->timestamp('core_at')->nullable()->index();
            $table->float('brix_core')->nullable();
            $table->float('pol_core')->nullable();
            $table->float('pol_baca_core')->nullable();
            $table->float('rendemen_core')->nullable();
            $table->float('ph_core')->nullable();
            $table->float('pol_core_riil')->nullable();
            $table->float('rendemen_core_riil')->nullable();

            $table->timestamp('ari_at')->nullable()->index();
            $table->float('brix_ari')->nullable();
            $table->float('pol_ari')->nullable();
            $table->float('pol_baca_ari')->nullable();
            $table->float('rendemen_ari')->nullable();
            $table->float('ph_ari')->nullable();
            $table->float('pol_ari_riil')->nullable();
            $table->float('rendemen_ari_riil')->nullable();

            $table->timestamp('mbs_at')->nullable()->index();
            $table->tinyInteger('meja_tebu')->nullable();

            // Ini akan diubah dinamis
            $table->float('daduk')->nullable();
            $table->float('akar')->nullable();
            $table->float('tali_pucuk')->nullable();
            $table->float('pucuk')->nullable();
            $table->float('sogolan')->nullable();
            $table->float('tebu_muda')->nullable();
            $table->float('lelesan')->nullable();
            $table->float('terbakar')->nullable();
            $table->float('kocor_air')->nullable();
            $table->float('atpsd')->nullable();
            // Ini akan diubah dinamis

            $table->float('reward_or_punishment')->nullable();
            $table->float('rendemen_mbs')->nullable();

            $table->float('brix_npp')->nullable();
            $table->float('pol_npp')->nullable();
            $table->float('rendemen_npp')->nullable();

            $table->float('berat_rafaksi')->nullable();
            $table->string('rafaksi', 50)->nullable();
            $table->string('grade', 1)->nullable();

            $table->longText('bukti_cctv_statis')->nullable();
            $table->longText('bukti_cctv_ptz')->nullable();

            $table->text('mutu_tebu')->nullable();
            $table->float('bobot_tebu')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analisa_on_farms');
    }
};
