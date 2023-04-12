<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        return Department::all();
    }

    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required|unique:departments,name',
        ]);

        $department = Department::create($request->all());
        if($department){
            $data= array(
                'status' => 201,
                'message' => 'New Department Created Successfully',
            );
            
            return response()->json($data, 201);
        }else {

            return response()->json(['error' => 'Something Went Wrong'], 204);
        }
        
    }

    public function show(Department $department)
    {   
        return $department;
    }

    public function update(Request $request, Department $department)
    {   
       
        $request->validate([
            'name' => 'required',
        ]);

        $department->update($request->all());

         if($department){
            $data= array(
                'status' => 201,
                'message' => 'Department Updated Successfully',
            );
            
            return response()->json($data, 201);
        }else {

            return response()->json(['error' => 'Something Went Wrong'], 204);
        }
    }

    public function destroy(Department $department)
    {
        $department->delete();

        // return response()->json(null, 204);
        return response()->json([
            "success" => true,
            "message" => "Department deleted successfully.",
            "departments" => $department
            ],204);
    }
}
