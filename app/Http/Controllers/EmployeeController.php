<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Resources\EmployeeResource;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeController extends Controller
{

    public function index(Request $request)
    {
        $filters = $request->only([
            'name',
            'age',
            'email',
            'gender',
            'phone_number',
            'date_of_birth',
            'address',
            'position',
            'department',
            'salary'
        ]);

        $query = Employee::query();

        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                $query->where($field, 'LIKE', "%{$value}%");
            }
        }

        $employees = $query->orderBy('created_at', 'desc')->paginate(5);

        return response()->json([
            'data' => EmployeeResource::collection($employees),
            'message' => 'Employees retrieved successfully'
        ], 200);
    }


    public function store(EmployeeStoreRequest $request)
    {
        $employee = Employee::create($request->validated());

        return response()->json([
            'data' => new EmployeeResource($employee),
            'message' => 'Employee created successfully'
        ], 201);
    }

    public function show(Employee $employee)
    {
        return response()->json([
            'data' => new EmployeeResource($employee),
            'message' => 'Employee retrieved successfully'
        ], 200);
    }


    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        $employee->update($request->validated());
        return response()->json([
            'data' => new EmployeeResource($employee),
            'message' => 'Employee updated successfully'
        ], 200);
    }

    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();
            return response()->json([
                'message' => 'Employee deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete employee',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
