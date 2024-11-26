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

            // Nettoyer le nom du client
            $cleanName = Str::slug($clientName, '-', 'fr');

            // Générer une chaîne aléatoire unique
            $uniqueString = Str::random(6);

            // Créer le slug en combinant le nom, l'ID et la chaîne unique
            $slug = strtolower(
                $cleanName . '-' .
                    $id . '-' .
                    $uniqueString
            );

            // Vérifier si le slug existe déjà
            $slugExists = User::where('slug', $slug)->exists();

            $attempts++;
        } while ($slugExists);

        return $slug;
    }

    /**
     * Génère un slug court pour les URLs
     */
    public static function generateShortSlug($id, $maxAttempts = 10)
    {
        $attempts = 0;

        do {
            if ($attempts >= $maxAttempts) {
                throw new \Exception("Impossible de générer un slug court unique après {$maxAttempts} tentatives.");
            }

            // Générer une chaîne aléatoire de 8 caractères
            $uniqueString = Str::random(8);

            // Créer le slug court
            $slug = strtolower($uniqueString);

            // Vérifier si le slug existe déjà
            $slugExists = User::where('slug', $slug)->exists();

            $attempts++;
        } while ($slugExists);

        return $slug;
    }

    /**
     * Vérifie si un slug est valide
     */
    public static function isValidSlug($slug)
    {
        // Vérifier si le slug correspond au format attendu
        return preg_match('/^[a-z0-9\-]+$/', $slug);
    }

    /**
     * Nettoie un slug existant
     */
    public static function cleanSlug($slug)
    {
        // Convertir en minuscules
        $slug = strtolower($slug);

        // Remplacer les caractères spéciaux par des tirets
        $slug = preg_replace('/[^a-z0-9\-]/', '-', $slug);

        // Remplacer les multiples tirets par un seul
        $slug = preg_replace('/-+/', '-', $slug);

        // Supprimer les tirets au début et à la fin
        $slug = trim($slug, '-');

        return $slug;
    }
}
