<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use App\Models\User;

class SlugHelper
{
    public static function generateUniqueSlug($clientName, $id, $maxAttempts = 10)
    {
        $attempts = 0;

        do {
            if ($attempts >= $maxAttempts) {
                throw new \Exception("Impossible de générer un slug unique après {$maxAttempts} tentatives.");
            }

            // Caractères spéciaux autorisés
            $specialChars = ['#', '@', '$', '%', '&', '*', '!'];

            // Prendre 2 caractères spéciaux aléatoires
            $randomSpecialChars = array_rand($specialChars, 2);
            $specialChar1 = $specialChars[$randomSpecialChars[0]];
            $specialChar2 = $specialChars[$randomSpecialChars[1]];

            // Générer une chaîne aléatoire de 3 caractères
            $randomString = Str::random(3);

            // Créer le slug
            $slug = strtolower($randomString . $specialChar1 . $id . $specialChar2 . Str::random(3));

            // Vérifier si le slug existe déjà
            $slugExists = User::where('slug', $slug)->exists();

            $attempts++;
        } while ($slugExists);

        return $slug;
    }
}
