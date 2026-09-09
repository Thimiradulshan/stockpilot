<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display the user administration area.
     */
    public function index(): Response
    {
        $this->authorize('viewAny', User::class);

        return response('user-administration');
    }
}
