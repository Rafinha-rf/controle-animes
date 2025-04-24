<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('watch_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('episode_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['not_watched', 'in_progress', 'watched'])->default('not_watched');
            $table->timestamp('watched_at')->nullable();
            $table->integer('current_time')->nullable(); // Para episódios em andamento
            $table->timestamps();

            // Garante que um usuário só pode ter um registro de progresso por episódio
            $table->unique(['user_id', 'episode_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('watch_progress');
    }
}; 