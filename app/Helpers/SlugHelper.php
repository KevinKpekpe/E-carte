<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use App\Models\User;

class SlugHelper
{
    public static function generateUniqueSlug($id, $maxAttempts = 10)
    {
        $attempts = 0;

        do {
            if ($attempts >= $maxAttempts) {
                throw new \Exception("Impossible de générer un slug unique après {$maxAttempts} tentatives.");
            }

            // Générer une chaîne aléatoire de 12 caractères
            $uniqueString = Str::random(12);

            // Créer le slug en combinant l'ID et la chaîne aléatoire
            $slug = strtolower(
                $id . '-' . $uniqueString
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
    public static function generateShortSlug($maxAttempts = 10)
    {
        $attempts = 0;

        do {
            if ($attempts >= $maxAttempts) {
                throw new \Exception("Impossible de générer un slug court unique après {$maxAttempts} tentatives.");
            }

            // Générer une chaîne aléatoire de 10 caractères
            $uniqueString = Str::random(10);

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
        // Vérifier si le slug correspond au format attendu (caractères alphanumériques et tirets)
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
