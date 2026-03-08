<?php

namespace App\Http\Controllers;

use App\Models\SchoolEquipment\SchoolEquipmentAllotmentClass;
use App\Models\SchoolEquipment\SchoolEquipmentCategories;
use App\Models\SchoolEquipment\SchoolEquipmentClassification;
use App\Models\SchoolEquipment\SchoolEquipmentCondition;
use App\Models\SchoolEquipment\SchoolEquipmentDisposition;
use App\Models\SchoolEquipment\SchoolEquipmentDocumentType;
use App\Models\SchoolEquipment\SchoolEquipmentManufacturer;
use App\Models\SchoolEquipment\SchoolEquipmentModeOfAcquisition;
use App\Models\SchoolEquipment\SchoolEquipmentSourceOfAcquisition;
use App\Models\SchoolEquipment\SchoolEquipmentSourceOfFund;
use App\Models\SchoolEquipment\SchoolEquipmentTransactionType;
use App\Models\SchoolEquipment\SchoolEquipmentUnitOfMeasure;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminSchoolEquipmentLookupController extends Controller
{
    private function modelMap(): array
    {
        return [
            'unit_of_measure' => SchoolEquipmentUnitOfMeasure::class,
            'manufacturer' => SchoolEquipmentManufacturer::class,
            'category' => SchoolEquipmentCategories::class,
            'classification' => SchoolEquipmentClassification::class,
            'mode_of_acquisition' => SchoolEquipmentModeOfAcquisition::class,
            'source_of_acquisition' => SchoolEquipmentSourceOfAcquisition::class,
            'source_of_fund' => SchoolEquipmentSourceOfFund::class,
            'allotment_class' => SchoolEquipmentAllotmentClass::class,
            'transaction_type' => SchoolEquipmentTransactionType::class,
            'condition' => SchoolEquipmentCondition::class,
            'disposition_status' => SchoolEquipmentDisposition::class,
            'document_type' => SchoolEquipmentDocumentType::class,
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

        return view('AdminSide.SchoolEquipment.index', compact('itemsByType'));
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
        $table = (new $modelClass)->getTable();

        $validated = $request->validate([
            'type' => ['required', 'string'],
            'id' => ['required', 'integer'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique($table, 'name')->ignore($request->id, 'id'),
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
