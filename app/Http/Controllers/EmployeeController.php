<?php

namespace App\Http\Controllers;

use App\Models\EmployeePosition;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employee_position = EmployeePosition::all();

        return view('AdminSide.Employee.index', compact('employee_position'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:position_title,name',
        ], [
            'name.unique' => 'The position is already in the list.',
            'name.required' => 'Please enter a position name.',
        ]);
        $store = EmployeePosition::create($validated);
        if ($store) {
            return redirect()->back()->with('success', 'Position added succesfully');
        }
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'name' => [
                'required',
                'string',
                Rule::unique('position_title', 'name')->ignore($request->id, 'pk_school_position_id'),
            ],
        ], [
            'name.unique' => 'The position is already in the list.',
        ]);

        $positions = EmployeePosition::findOrFail($validated['id']);
        $positions->update([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Employee Position is updated successfully.');
    }

    public function delete($id)
    {
        try {
            $delete = EmployeePosition::findOrFail($id);

            if ($delete) {
                $delete->delete();

                return redirect()->back()->with('success', 'Employee position deleted successfully.');
            } else {
                return redirect()->back()->with('error', 'Unable to delete this position.');
            }
        } catch (QueryException $e) {
            // Error code 1451 = Cannot delete or update a parent row: a foreign key constraint fails
            if ($e->errorInfo[1] == 1451) {
                return redirect()->back()->with('error', 'This employee position is assigned and cannot be deleted.');
            }

            return redirect()->back()->with('error', 'Database error: '.$e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
