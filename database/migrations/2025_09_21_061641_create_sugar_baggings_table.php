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
        Schema::create('sugar_baggings', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');
            $table->integer('last_bag_id_chronous_a');
            $table->integer('last_bag_id_chronous_b');
            $table->integer('last_bag_id_chronous_c');
            $table->float('bag_qty_from_chronous_a');
            $table->float('bag_qty_from_chronous_b');
            $table->float('bag_qty_from_chronous_c');
            $table->float('sugar_total');
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
        Schema::dropIfExists('sugar_baggings');
    }
};
