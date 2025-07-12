<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        // return view ('Administrador.VerAdmins.show');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        return view('Administrador.VerAdmins.show', compact('admin'));
    }
}
