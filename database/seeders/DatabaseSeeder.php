<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Employee;
use App\Models\SocialLink;
use App\Models\UserType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Crée les types d'utilisateurs
        $superadminType = UserType::factory()->create(['name' => 'superadmin']);
        $classiqueType = UserType::factory()->create(['name' => 'classique']);
        $premiumType = UserType::factory()->create(['name' => 'premium']);
        $entrepriseType = UserType::factory()->create(['name' => 'entreprise']);

        // Crée 2 superadmins
        User::factory(2)->create(['user_type_id' => $superadminType->id]);

        // Crée 2 utilisateurs classiques
        User::factory(2)->create(['user_type_id' => $classiqueType->id]);

        // Crée 4 utilisateurs premium
        User::factory(4)->create(['user_type_id' => $premiumType->id]);

        // Crée 4 entreprises avec relations
        User::factory(4)->create(['user_type_id' => $entrepriseType->id])->each(function ($user) {
            // Associe une compagnie
            $company = Company::factory()->create(['user_id' => $user->id]);

            // Associe 10 employés à la compagnie
            Employee::factory(10)->create(['company_id' => $company->id]);

            // Associe au moins 2 liens sociaux à l'utilisateur
            SocialLink::factory(2)->create(['user_id' => $user->id]);
        });
    }
}
