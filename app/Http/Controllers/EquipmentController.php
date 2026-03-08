<?php

namespace App\Http\Controllers;

use App\Models\Equipment\EquipmentBiometricDetails;
use App\Models\Equipment\EquipmentBiometricType;
use App\Models\Equipment\EquipmentBrand;
use App\Models\Equipment\EquipmentCCTVType;
use App\Models\Equipment\EquipmentDetails;
use App\Models\Equipment\EquipmentIncharge;
use App\Models\Equipment\EquipmentInstaller;
use App\Models\Equipment\EquipmentLocation;
use App\Models\Equipment\EquipmentPowerSource;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EquipmentController extends Controller
{
    private function modelMap(): array
    {
        return [
            'camera_type' => EquipmentCCTVType::class,
            'biometric_type' => EquipmentBiometricType::class,
            'powersource' => EquipmentPowerSource::class,
            'installer' => EquipmentInstaller::class,
            'brand' => EquipmentBrand::class,
            'location' => EquipmentLocation::class,
            'incharge' => EquipmentIncharge::class,
        ];
    }

    private function resolveModelClass(string $type): string
    {
        $models = $this->modelMap();
        abort_unless(isset($models[$type]), 404);

        return $models[$type];
    }

    public function showBiometrics()
    {
        $totals = EquipmentBiometricDetails::select('school_id', DB::raw('SUM(no_of_units) as total_amount'))

            ->with('schools') // assuming you have a relation in your model
            ->groupBy('school_id')
            ->orderBy('total_amount', 'DESC')
            ->get();

        $biometrics_model = EquipmentDetails::where('equipment_type_id', 2)
            ->with(['brand_model', 'biometric_details'])
            ->get()
            ->groupBy('equipment_brand_model_id')
            ->map(function ($group) {
                $brand = $group->first()->brand_model;
                $count = $group->count(); // how many records share this model

                // Sum up all no_of_units across biometric_details of this model
                $totalUnits = $group->sum(function ($item) {
                    return $item->biometric_details->sum('no_of_units');
                });

                return (object) [
                    'brand' => $brand,
                    'count' => $count,
                    'total_units' => $totalUnits,
                    'total' => $count * $totalUnits,
                ];
            })
            ->values(); // reset collection keys
        $biometrics_power_source = EquipmentDetails::where('equipment_type_id', 2)
            ->with(['powersource', 'biometric_details'])
            ->get()
            ->groupBy('equipment_power_source_id')
            ->map(function ($group) {
                $power_source = $group->first()->powersource;
                $count = $group->count(); // how many records share this model

                // Sum up all no_of_units across biometric_details of this model
                $totalUnits = $group->sum(function ($item) {
                    return $item->biometric_details->sum('no_of_units');
                });

                return (object) [
                    'power_source' => $power_source,
                    'count' => $count,
                    'total_units' => $totalUnits,
                    'total' => $count * $totalUnits,
                ];
            })
            ->values();

        // dd($biometrics_model);
        return view('AdminSide.Equipment.Biometrics.show', compact('totals', 'biometrics_model', 'biometrics_power_source'));
    }

    public function index()
    {
        $itemsByType = [];
        foreach ($this->modelMap() as $type => $modelClass) {
            $itemsByType[$type] = $modelClass::listForAdmin();
        }

        return view('AdminSide.Equipment.index', compact('itemsByType'));
    }

    public function store(Request $request)
    {
        $type = $request->input('type', $request->input('target'));
        $modelClass = $this->resolveModelClass($type);
        $table = (new $modelClass)->getTable();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique($table, 'name')],
        ]);
        $modelClass::createFromName($validated['name']);

        return redirect()->route('equipment.index.list')->with('success', 'New equipment item has been added.');
    }

    public function update(Request $request)
    {
        $type = $request->input('type', $request->input('target'));
        $modelClass = $this->resolveModelClass($type);
        $model = new $modelClass;
        $table = $model->getTable();
        $keyName = $model->getKeyName();

        $validated = $request->validate([
            'id' => ['required', 'integer'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique($table, 'name')->ignore($request->id, $keyName),
            ],
        ]);
        $modelClass::updateNameById((int) $validated['id'], $validated['name']);

        return redirect()->route('equipment.index.list')->with('success', 'Equipment item has been updated.');
    }

    public function destroy(int $id, string $type)
    {
        try {
            $modelClass = $this->resolveModelClass($type);
            $modelClass::deleteById($id);

            return redirect()->route('equipment.index.list')->with('success', ucfirst($type).' has been deleted.');
        } catch (QueryException $e) {
            // Check for foreign key constraint violation (1451 in MySQL)
            if ($e->errorInfo[1] == 1451) {
                return redirect()->route('equipment.index.list')
                    ->with('error', 'This '.$type.' cannot be deleted because it is still assigned to other records.');
            }

            // Any other DB error
            return redirect()->route('equipment.index.list')
                ->with('error', 'An error occurred while trying to delete the '.$type.'.');
        }
    }
}
