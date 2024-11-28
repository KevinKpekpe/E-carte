<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index(){
        return view('admin.profil.index');
    }
    public function edit(){
        return view('admin.profil.edit');
    }
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Gestion de la photo
            $photoPath = $user->photo_profile;
            if ($request->hasFile('photo')) {
                // Suppression de l'ancienne photo si elle existe
                if ($photoPath && Storage::disk('public')->exists($photoPath)) {
                    Storage::disk('public')->delete($photoPath);
                }
                $photoPath = $request->file('photo')->store('profile-photos', 'public');
            }

            // Mise à jour des informations de l'utilisateur
            $user->update([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'telephone' => $request->telephone,
                'photo_profile' => $photoPath,
            ]);
            DB::commit();

            return redirect()->route('admin.profil')
            ->with('success', 'Votre profil a été mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour du profil: ' . $e->getMessage())
                ->withInput();
        }
    }
    /**
     * Supprime le compte premium
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
    {
        try {
            DB::beginTransaction();

            $user = auth()->user();

            // Suppression de la photo de profil
            if ($user->photo_profile && Storage::disk('public')->exists($user->photo_profile)) {
                Storage::disk('public')->delete($user->photo_profile);
            }

            // Suppression du fichier VCard
            if ($user->vcard_file && Storage::exists($user->vcard_file)) {
                Storage::delete($user->vcard_file);
            }

            // Suppression des liens sociaux
            SocialLink::where('user_id', $user->id)->delete();

            // Suppression de l'utilisateur
            $user->delete();

            DB::commit();

            // Déconnexion de l'utilisateur
            auth()->logout();

            return redirect()->route('login')
            ->with('success', 'Votre compte a été supprimé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Une erreur est survenue lors de la suppression du compte : ' );
        }
    }
}
