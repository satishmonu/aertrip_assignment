<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employeecontacts;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {  
        $users = User::with('contacts')->get();
        return $users;
    }

    public function store(Request $request)
    {   
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string',
            'user_id' => 'required|integer',
            'email' => 'required|string',
            'phone_number' => 'required|max:10',
            'address'      => 'required',
        ]);
    
        $User = User::create([
            'name' => $validated['name'],
            'user_id' => $validated['user_id'],
            'email'       => $validated['email'],
        ]);
    
        $Employeecontacts = Employeecontacts::create([
            'employee_id' => $User->id,
            'phone_number' => $validated['phone_number'],
            'address'      => $validated['address'],
        ]);

        return response()->json($User, 201);
    }

    public function show(User $user)
    {   
        return $user;
    }

    public function update(Request $request, User $user)
    {   
        dd($request->all());
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
