<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display the category management area.
     */
    public function index(): Response
    {
        $this->authorize('viewAny', Category::class);

        return response('category-management');
    }
}
