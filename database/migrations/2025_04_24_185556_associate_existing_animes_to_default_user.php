<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Anime;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('animes', 'user_id')) {
            Schema::table('animes', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id');
            });
        }

        // Pega o primeiro usuário do sistema ou cria um se não existir
        $user = User::first();
        if ($user) {
            // Associa todos os animes existentes a este usuário
            Anime::whereNull('user_id')->update(['user_id' => $user->id]);
        }

        // Agora torna a coluna não nullable e adiciona a chave estrangeira
        Schema::table('animes', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
            if (!Schema::hasColumn('animes', 'user_id_foreign')) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('animes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
