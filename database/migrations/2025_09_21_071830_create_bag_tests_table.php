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
        Schema::create('bag_tests', function (Blueprint $table) {
            $table->id();
            $table->date('arrival_date');
            $table->date('test_date');
            $table->tinyInteger('batch');
            $table->decimal('p_nilai_outer', 10, 2);
            $table->string('p_ket_outer', 255);
            $table->decimal('l_nilai_outer', 10, 2);
            $table->string('l_ket_outer', 255);
            $table->decimal('p_nilai_inner', 10, 2);
            $table->string('p_ket_inner', 255);
            $table->decimal('l_nilai_inner', 10, 2);
            $table->string('l_ket_inner', 255);
            $table->decimal('berat_outer', 10, 2);
            $table->string('berat_outer_ket', 255);
            $table->decimal('berat_inner', 10, 2);
            $table->string('berat_inner_ket', 255);
            $table->decimal('raw_outer', 10, 3);
            $table->decimal('tebal_outer', 10, 3);
            $table->string('tebal_outer_ket', 255);
            $table->decimal('raw_inner', 10, 3);
            $table->decimal('tebal_inner', 10, 3);
            $table->string('tebal_inner_ket', 255);
            $table->decimal('mesh_alas', 10, 2);
            $table->string('mesh_ket_alas', 255);
            $table->decimal('mesh_tinggi', 10, 2);
            $table->string('mesh_ket_tinggi', 255);
            $table->decimal('denier_nilai', 10, 2);
            $table->string('denier_ket', 255);
            $table->foreignId('user_id')->constrained();
            $table->timestamp('created_at')->useCurrent()->index();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bag_tests');
    }
};
