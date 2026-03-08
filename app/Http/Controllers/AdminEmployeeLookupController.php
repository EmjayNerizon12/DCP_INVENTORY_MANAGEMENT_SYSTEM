<?php

namespace App\Http\Controllers;

use App\Models\EmpCauseOfSeparation;
use App\Models\EmployeePosition;
use App\Models\EmpPosition;
use App\Models\EmpROOffice;
use App\Models\EmpSDOOffice;
use App\Models\EmpSourceOfFund;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminEmployeeLookupController extends Controller
{
    private function modelMap(): array
    {
        return [
            'employee_title' => EmployeePosition::class,
            'employee_position' => EmpPosition::class,
            'ro_office' => EmpROOffice::class,
            'sdo_office' => EmpSDOOffice::class,
            'source_of_fund' => EmpSourceOfFund::class,
            'cause_of_separation' => EmpCauseOfSeparation::class,
        ];
    }

    private function resolveModelClass(string $type): string
    {
        $models = $this->modelMap();
        abort_unless(isset($models[$type]), 404);

        return $models[$type];
    }

    public function index()
    {
        $itemsByType = [];
        foreach ($this->modelMap() as $type => $modelClass) {
            $itemsByType[$type] = $modelClass::listForAdmin();
        }

        return view('AdminSide.Employee.index', compact('itemsByType'));
    }

    public function store(Request $request)
    {
        $type = $request->input('type');
        $modelClass = $this->resolveModelClass($type);
        $table = (new $modelClass)->getTable();

        $validated = $request->validate([
            'type' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255', Rule::unique($table, 'name')],
        ], [
            'name.unique' => 'This value already exists in the list.',
        ]);

        $modelClass::createFromName($validated['name']);

        return redirect()->back()->with('success', 'Saved successfully.');
    }

    public function update(Request $request)
    {
        $type = $request->input('type');
        $modelClass = $this->resolveModelClass($type);
        $model = new $modelClass;
        $table = $model->getTable();
        $keyName = $model->getKeyName();

        $validated = $request->validate([
            'type' => ['required', 'string'],
            'id' => ['required', 'integer'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique($table, 'name')->ignore($request->id, $keyName),
            ],
        ], [
            'name.unique' => 'This value already exists in the list.',
        ]);

        $modelClass::updateNameById((int) $validated['id'], $validated['name']);

        return redirect()->back()->with('success', 'Updated successfully.');
    }

    public function destroy(int $id, string $type)
    {
        $modelClass = $this->resolveModelClass($type);

        try {
            $modelClass::deleteById($id);
        } catch (QueryException $e) {
            if ((int) ($e->errorInfo[1] ?? 0) === 1451) {
                return redirect()->back()
                    ->with('error', 'This item is assigned and cannot be deleted.');
            }

            return redirect()->back()
                ->with('error', 'Database error: '.$e->getMessage());
        }

        return redirect()->back()->with('success', 'Deleted successfully.');
    }
}
