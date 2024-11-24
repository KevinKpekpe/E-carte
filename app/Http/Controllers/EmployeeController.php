<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Traits\VcardGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    use VcardGenerator;

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

    public function create()
    {
        return view('clients.entreprise.employee.form');
    }
    public function edit(Employee $employee)
    {
        Gate::authorize('manage', $employee);
        return view('clients.entreprise.employee.form', compact('employee'));
    }

    public function store(Request $request)
    {
        $company = auth()->user()->company;

        // Vérifier si la limite d'employés est atteinte
        if ($company->employees()->count() >= $company->nombre_employes) {
            return redirect()->back()
                ->with('error', 'Vous avez atteint la limite du nombre d\'employés autorisés.')
                ->withInput();
        }

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'telephone' => 'required|string|max:20',
            'profession' => 'required|string|max:255',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            DB::beginTransaction();

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
            ]);

            // Génération du fichier VCard
            $vcardPath = $this->generateVcard($employee);
            $employee->update(['vcard_file' => $vcardPath]);

            DB::commit();

            return redirect()->route('employees.index')
            ->with('success', 'Employé ajouté avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de l\'ajout de l\'employé.')
                ->withInput();
        }
    }
    public function update(Request $request, Employee $employee)
    {
        Gate::authorize('manage',$employee);

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees,email,' . $employee->id,
            'telephone' => 'required|string|max:20',
            'profession' => 'required|string|max:255',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

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
                ->with('error', 'Une erreur est survenue lors de la mise à jour.')
                ->withInput();
        }
    }

    public function destroy(Employee $employee)
    {
        Gate::authorize('modify', $employee);

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
            ->with('success', ' Employé supprimé avec success');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de la suppression.'
            ]);
        }
    }
}
