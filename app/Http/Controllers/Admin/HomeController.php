<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Compter le nombre total d'utilisateurs
        $totalUsers = User::count();

        // Compter les utilisateurs actifs
        $activeUsers = User::where('is_active', true)->count();

        // Compter les utilisateurs inactifs
        $inactiveUsers = User::where('is_active', false)->count();

        // Calculer les pourcentages
        $activePercentage = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 0;
        $inactivePercentage = $totalUsers > 0 ? round(($inactiveUsers / $totalUsers) * 100) : 0;

        return view('admin.index', compact('totalUsers', 'activeUsers', 'inactiveUsers', 'activePercentage', 'inactivePercentage'));
    }
}
