<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display the product management area.
     */
    public function index(): Response
    {
        $this->authorize('viewAny', Product::class);

        return response('product-management');
    }
}
