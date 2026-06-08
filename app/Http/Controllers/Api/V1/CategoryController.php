<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;

class CategoryController extends Controller
{
    /**
     * GET /api/v1/categories
     * List all service categories.
     */
    public function index()
    {
        $categories = ServiceCategory::orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data'    => $categories,
        ]);
    }
}
