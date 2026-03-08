<?php

namespace App\Http\Controllers;

use App\Models\DCPBatchItemBrand;
use App\Models\DCPCurrentCondition;
use App\Models\DCPDeliveryCondintion;
use App\Models\DCPItemAssignedType;
use App\Models\DCPItemBrand;
use App\Models\DCPItemLocation;
use App\Models\DCPItemModeDelivery;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminDcpLookupController extends Controller
{
    private function modelMap(): array
    {
        return [
            'delivery_mode' => DCPItemModeDelivery::class,
            'delivery_condition' => DCPDeliveryCondintion::class,
            'supplier' => DCPItemBrand::class,
            'brand' => DCPBatchItemBrand::class,
            'current_condition' => DCPCurrentCondition::class,
            'assigned_user_type' => DCPItemAssignedType::class,
            'assigned_location' => DCPItemLocation::class,
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

        return view('AdminSide.Product.index', compact('itemsByType'));
    }

    public function store(Request $request)
    {
        $type = $request->input('type');
        $modelClass = $this->resolveModelClass($type);
        $model = new $modelClass;
        $table = $model->getTable();
        $nameColumn = $modelClass::lookupNameColumn();

        $validated = $request->validate([
            'type' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255', Rule::unique($table, $nameColumn)],
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
        $nameColumn = $modelClass::lookupNameColumn();

        $validated = $request->validate([
            'type' => ['required', 'string'],
            'id' => ['required', 'integer'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique($table, $nameColumn)->ignore($request->id, $keyName),
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
