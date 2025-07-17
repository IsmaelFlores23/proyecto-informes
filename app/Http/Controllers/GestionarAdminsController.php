<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class GestionarAdminsController extends Controller
{
     public function index()
    {
        // Cambiamos la consulta para usar la relación con roles
        $admins = User::whereHas('role', function($query) {
            $query->where('nombre_role', 'admin');
        })->get();
        return view ('Administrador.GestionarAdmins.index', compact('admins'));
    }

    public function edit(User $GestionarAdmin)
    {
        // Cambiamos la consulta para usar la relación con roles
        $admins = User::whereHas('role', function($query) {
            $query->where('nombre_role', 'admin');
        })->get();
        return view('Administrador.GestionarAdmins.index', compact('admins'))->with('editando', $GestionarAdmin);
    }

    public function update(Request $request, User $GestionarAdmin)
    {
        // Validación de datos
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'facultad' => ['required', 'string', 'max:50'],
            'campus' => ['required', 'string', 'max:50'],
        ];

        // Solo validamos email y numero_cuenta si cambiaron
        if ($GestionarAdmin->email != $request->email) {
            $rules['email'] = ['required', 'email', 'unique:users,email'];
        }

        if ($GestionarAdmin->numero_cuenta != $request->numero_cuenta) {
            $rules['numero_cuenta'] = ['required', 'string', 'max:13', 'unique:users,numero_cuenta'];
        }

        // Solo validamos password si se proporcionó uno nuevo
        if ($request->filled('password')) {
            $rules['password'] = ['string', 'min:6'];
        }

        $validated = $request->validate($rules);

        // Preparamos los datos a actualizar
        $dataToUpdate = [
            'numero_cuenta' => $request->numero_cuenta,
            'name' => $request->name,
            'email' => $request->email,
            'facultad' => $request->facultad,
            'campus' => $request->campus,
        ];

        // Solo actualizamos la contraseña si se proporcionó una nueva
        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        $GestionarAdmin->update($dataToUpdate);

        return redirect()->route('GestionarAdmins.index')->with('success', 'Administrador actualizado correctamente');
    }
  

    
    public function store(Request $request)
    {
        // Validación de datos
       $request->validate([
            'numero_cuenta' => ['required', 'string', 'max:13', 'unique:users,numero_cuenta'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'facultad' => ['required', 'string', 'max:50'],
            'campus' => ['required', 'string', 'max:50'],
        ]);

        // Creación del nuevo admin
        User::create([
            'numero_cuenta' => $request->numero_cuenta,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Forzamos el role a 'admin'
            'facultad' => $request->facultad,
            'campus' => $request->campus,
        ]);

        return redirect()->route('GestionarAdmins.index')->with('success', 'Admin creado exitosamente.');
    }


     public function show(Request $request)
    {

    }

    public function destroy($id)
    {
        $gestionarAdmin = User::findOrFail($id);
        $gestionarAdmin->delete();
        return redirect()->route('GestionarAdmins.index')->with('success', 'Administrador eliminado correctamente');
    }

}