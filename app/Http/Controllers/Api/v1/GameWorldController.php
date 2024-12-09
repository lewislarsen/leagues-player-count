<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\GameWorld;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class GameWorldController
 *
 * Handles operations related to GameWorld entities such as filtering, sorting, and searching.
 */
class GameWorldController extends Controller
{
    /**
     * List all GameWorld records with filtering, sorting, and pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $query = GameWorld::query();

        // Apply filtering
        $filters = $request->only(['type', 'country', 'min_population']);
        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }
        if (! empty($filters['country'])) {
            $query->where('country', $filters['country']);
        }
        if (! empty($filters['min_population'])) {
            $query->where('population', '>=', (int) $filters['min_population']);
        }

        // Sorting with validation
        $allowedSortFields = ['id', 'population', 'type', 'country', 'created_at'];
        $sortBy = $request->query('sort_by', 'id');
        $sortOrder = $request->query('sort_order', 'asc');
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder === 'desc' ? 'desc' : 'asc');
        }

        // Pagination
        $perPage = (int) $request->query('per_page', 50);
        $perPage = max(1, min($perPage, 100)); // Limit results to 1-100 per page
        $worlds = $query->paginate($perPage);

        return $this->apiResponse($worlds);
    }

    /**
     * Retrieve GameWorld records by world number.
     */
    public function listByWorldNumber(int $worldNumber): JsonResponse
    {
        $worlds = GameWorld::whereRaw(
            'REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(world_name, "OldSchool", ""), " ", ""), "-", ""), "_", ""), ".", "") = ?',
            [(string) $worldNumber]
        )->get();

        if ($worlds->isEmpty()) {
            return $this->apiResponse(null, 404, 'No worlds found for the specified world number.');
        }

        return $this->apiResponse($worlds);
    }

    /**
     * Retrieve GameWorld records by activity.
     */
    public function listByWorldActivity(string $worldActivity): JsonResponse
    {
        $worlds = GameWorld::where('activity', 'LIKE', "%{$worldActivity}%")->get();

        if ($worlds->isEmpty()) {
            return $this->apiResponse(null, 404, 'No worlds found for the specified activity.');
        }

        return $this->apiResponse($worlds);
    }

    /**
     * Search for GameWorld records using multiple criteria.
     */
    public function search(Request $request): JsonResponse
    {
        $query = GameWorld::query();

        // Apply world number search
        if ($worldNumber = $request->query('world_number')) {
            $query->whereRaw(
                'REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(world_name, "OldSchool", ""), " ", ""), "-", ""), "_", ""), ".", "") = ?',
                [(string) $worldNumber]
            );
        }

        // Apply activity search
        if ($worldActivity = $request->query('world_activity')) {
            $query->where('activity', 'LIKE', "%{$worldActivity}%");
        }

        // Apply type filtering
        if ($type = $request->query('type')) {
            $query->where('type', $type);
        }

        $worlds = $query->get();

        if ($worlds->isEmpty()) {
            return $this->apiResponse(null, 404, 'No worlds found for the given criteria.');
        }

        return $this->apiResponse($worlds);
    }

    /**
     * Generate a standardized JSON API response.
     */
    private function apiResponse(mixed $data, int $status = 200, ?string $message = null): JsonResponse
    {
        return response()->json([
            'success' => $status < 400,
            'data' => $data,
            'message' => $message ?? ($status < 400 ? 'Request successful.' : 'An error occurred.'),
        ], $status);
    }
}
