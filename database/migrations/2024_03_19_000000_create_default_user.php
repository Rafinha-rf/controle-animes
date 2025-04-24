<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Criar o usuário padrão
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Usuário Padrão',
            'email' => 'default@example.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        DB::table('users')->where('id', 1)->delete();
    }
}; 