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
        //  dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'department_id' => 'required',
            'phone_number' => 'required|max:10',
            'address'      => 'required',
        ]);
    
        $User = User::create([
            'name' => $validated['name'],
            'department_id' => $validated['department_id'],
            'email'       => $validated['email'],
        ]);
        // dd($User->id);

        $Employeecontacts = Employeecontacts::create([
            'user_id'      => $User->id,
            'phone_number' => $validated['phone_number'],
            'address'      => $validated['address'],
        ]);

        return response()->json($User, 201);
    }

    public function show($id)
    {    
        $users = User::with('contacts')
                 ->where('id',$id)
                 ->get();

        return $users;
    }

    public function update(Request $request, $id)
    {   
        $input = $request->all();
        // dd($id);
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'phone_number' => 'required|max:10',
            'address'      => 'required',
        ]);

        $userdetail = User::find($id);
        // dd($userdetail);
        $userdetail->name =$input['name'];
        $userdetail->email =$input['email'];
        $userdetail->department_id =$input['department_id'];
        $userdetail->save();
        
        $contactdetail = Employeecontacts::where('user_id',$userdetail->id)->first();
        
        $contactdetail->phone_number = $input['phone_number'];
        $contactdetail->address = $input['address'];
        $contactdetail->save();

        return response()->json($userdetail, 201);
    }

    public function destroy($id)
    {   
         $user = User::find($id);
         if($user){
            $data =array(
                'msg' => 'Employee Deleted Successfully',
            );
            $result = $user->delete();
            return response()->json($data, 204);
         }else{
             $data =array(
                 'msg' => 'Employee id not found',
             );
            return response()->json($data, 204);
         }
         
    }

    public function search(Request $request)
    {   
        
        $query = $request->input('name');
        dd($request);
        $employees = User::where('name', 'like', "%$query%")->get();
        return $employees;
    }
}
