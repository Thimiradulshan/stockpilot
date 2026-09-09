<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    /**
     * Display the customer management area.
     */
    public function index(): Response
    {
        $this->authorize('viewAny', Customer::class);

        return response('customer-management');
    }
}
