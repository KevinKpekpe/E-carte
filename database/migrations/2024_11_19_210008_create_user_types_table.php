<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // superadmin, classique, premium, entreprise
            $table->string('description')->nullable();
            $table->timestamps();
        });
        DB::table('user_types')->insert([
            ['name' => 'superadmin', 'description' => 'Administrateur système'],
            ['name' => 'classique', 'description' => 'Utilisateur classique'],
            ['name' => 'premium', 'description' => 'Utilisateur premium'],
            ['name' => 'entreprise', 'description' => 'Compte entreprise'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_types');
    }
};
