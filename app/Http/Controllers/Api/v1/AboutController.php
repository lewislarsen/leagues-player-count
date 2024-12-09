<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class AboutController extends Controller
{
    /**
     * Provide metadata about the API.
     *
     * This route serves as an entry point for API users, offering essential details such as
     * the API's version, description, status, and maintainer information.
     */
    public function __invoke(): JsonResponse
    {
        $baseUrl = url('/'); // Dynamically retrieve the base URL of the application.

        return response()->json([
            'success' => true,
            'data' => [
                'name' => 'Old School RuneScape Game World API',
                'version' => '1.0.0',
                'description' => 'A public API for retrieving and searching game world data.',
                'status' => 'stable',
                'maintainer' => [
                    'name' => 'Lewis Larsen',
                    'email' => 'lewis@larsens.dev',
                ],
                'features' => [
                    'Filtering, sorting, and paginated world listings',
                    'Search worlds by number, activity, type, and country',
                ],
                'last_updated' => now()->toIso8601String(),
            ],
            'message' => 'API metadata retrieved successfully.',
        ]);
    }
}
