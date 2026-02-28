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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('room_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->enum('payment_type',['По карте', 'По номеру телефона']);
            $table->string('date');
            $table->enum('status', ['Новая', 'Мероприятие назначено', 'Мероприятие завершено']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
