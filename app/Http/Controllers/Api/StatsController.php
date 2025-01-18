<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Thefind;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class StatsController extends Controller
{
    /**
     * Get application statistics
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $totalFinds = Thefind::count();
            $totalUsers = User::count();
            $successfulFinds = Thefind::where('approval_status', 'approved')->count();
            
            $successRate = $totalFinds > 0 
                ? round(($successfulFinds / $totalFinds) * 100) 
                : 0;

            return response()->json([
                'finds' => $totalFinds,
                'users' => $totalUsers,
                'success' => $successRate
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Une erreur est survenue lors de la récupération des statistiques',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
