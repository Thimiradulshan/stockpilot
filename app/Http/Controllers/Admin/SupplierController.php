<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Response;

class SupplierController extends Controller
{
    /**
     * Display the supplier management area.
     */
    public function index(): Response
    {
        $this->authorize('viewAny', Supplier::class);

        return response('supplier-management');
    }
}
