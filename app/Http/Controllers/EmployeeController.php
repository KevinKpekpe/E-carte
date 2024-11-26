<?php

namespace App\Http\Controllers;

use App\Helpers\SlugHelper;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Traits\VcardGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    use VcardGenerator;

    /**
     * Affiche la liste des employés avec recherche et tri
     */
    public function index(Request $request)
    {
        $query = Employee::where('company_id', auth()->user()->company->id);

        // Gestion de la recherche
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'LIKE', "%{$search}%")
                    ->orWhere('prenom', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('profession', 'LIKE', "%{$search}%");
            });
        }

        // Gestion du tri
        if ($request->has('sort') && !empty($request->sort)) {
            switch ($request->sort) {
                case '1': // Tri par nom
                    $query->orderBy('nom')->orderBy('prenom');
                    break;
                case '2': // Tri par profession
                    $query->orderBy('profession');
                    break;
                case '3': // Tri par statut
                    $query->orderBy('is_active');
                    break;
            }
        }

        $employees = $query->paginate(10);

        return view('clients.entreprise.employee.index', compact('employees'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('clients.entreprise.employee.form');
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Employee $employee)
    {
        Gate::authorize('manage', $employee);
        return view('clients.entreprise.employee.form', compact('employee'));
    }

    /**
     * Enregistre un nouvel employé
     */
    public function store(StoreEmployeeRequest $request)
    {
        $company = auth()->user()->company;

        // Vérifier si la limite d'employés est atteinte
        if ($company->employees()->count() >= $company->nombre_employes) {
            return redirect()->back()
                ->with('error', 'Vous avez atteint la limite du nombre d\'employés autorisés.')
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $nextId = DB::table('employees')->max('id') + 1;

            // Traitement de la photo
            $photoPath = null;
            if ($request->hasFile('photo_profile')) {
                $photoPath = $request->file('photo_profile')->store('employee-photos', 'public');
            }

            // Création de l'employé
            $employee = Employee::create([
                'company_id' => $company->id,
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'profession' => $request->profession,
                'photo_profile' => $photoPath,
                'is_active' => true,
                'expiration_date' => now()->addYear(),
                'slug' => SlugHelper::generateUniqueSlug($request->nom . ' ' . $request->prenom, $nextId)
            ]);

            // Génération du fichier VCard
            $vcardPath = $this->generateVcard($employee);
            $employee->update(['vcard_file' => $vcardPath]);

            DB::commit();

            return redirect()->route('entreprise.employees.index')
                ->with('success', 'Employé ajouté avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de l\'ajout de l\'employé : ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Met à jour un employé
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        Gate::authorize('manage', $employee);

        try {
            DB::beginTransaction();

            if ($request->hasFile('photo_profile')) {
                if ($employee->photo_profile) {
                    Storage::disk('public')->delete($employee->photo_profile);
                }
                $photoPath = $request->file('photo_profile')->store('employee-photos', 'public');
                $employee->photo_profile = $photoPath;
            }

            $employee->update([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'profession' => $request->profession,
            ]);

            // Mise à jour du VCard
            if ($employee->vcard_file) {
                Storage::disk('public')->delete($employee->vcard_file);
            }
            $vcardPath = $this->generateVcard($employee);
            $employee->update(['vcard_file' => $vcardPath]);

            DB::commit();

            return redirect()->route('entreprise.employees.index')
                ->with('success', 'Informations de l\'employé mises à jour avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la mise à jour : ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Supprime un employé
     */
    public function destroy(Employee $employee)
    {
        Gate::authorize('manage', $employee);

        try {
            DB::beginTransaction();

            if ($employee->photo_profile) {
                Storage::disk('public')->delete($employee->photo_profile);
            }
            if ($employee->vcard_file) {
                Storage::disk('public')->delete($employee->vcard_file);
            }

            $employee->delete();

            DB::commit();

            return redirect()->route('entreprise.employees.index')
                ->with('success', 'Employé supprimé avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de la suppression : ' . $e->getMessage()
            ]);
        }
    }
}
