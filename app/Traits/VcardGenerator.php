<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use JeroenDesloovere\VCard\VCard;
use Illuminate\Support\Facades\Storage;

trait VcardGenerator
{
    public function generateVcard($user)
    {
        try {
            // Créer une nouvelle instance de VCard
            $vcard = new VCard();

            // Ajouter les informations de base
            $vcard->addName($user->nom, $user->prenom);
            $vcard->addCompany($user->profession);
            $vcard->addEmail($user->email);
            $vcard->addPhoneNumber($user->telephone, 'PREF;WORK');

            // Générer le nom du fichier
            $vcardFileName = 'vcard_' . $user->id . '.vcf';
            $vcardContent = $vcard->getOutput();

            // Assurer que le répertoire existe
            if (!Storage::disk('public')->exists('vcards')) {
                Storage::disk('public')->makeDirectory('vcards');
            }

            // Sauvegarder le fichier
            Storage::disk('public')->put('vcards/' . $vcardFileName, $vcardContent);

            return 'vcards/' . $vcardFileName;
        } catch (\Exception $e) {
            Log::error('Erreur lors de la génération de la vCard: ' . $e->getMessage());
            throw new \Exception('Impossible de générer la carte de visite virtuelle: ' . $e->getMessage());
        }
    }
}
