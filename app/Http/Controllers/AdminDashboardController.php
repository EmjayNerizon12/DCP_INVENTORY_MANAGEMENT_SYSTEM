<?php

namespace App\Http\Controllers;

use App\Models\DCPBatch;
use App\Models\DCPBatchItem;
use App\Models\DCPItemCondition;
use App\Models\DCPPackageTypes;
use App\Models\Equipment\EquipmentBiometricDetails;
use App\Models\Equipment\EquipmentCCTVDetails;
use App\Models\ISP\ISPDetails;
use App\Models\School;
use App\Models\SchoolEquipment\SchoolEquipment;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('AdminSide.Dashboard.index');
    }

    public function getAssetAndDeprecationValue()
    {
        $totalAssetValue = DCPBatchItem::query()->sum('unit_price');
        $totalDeprecationValue = DCPBatchItem::all()->sum('computed_deprecation_rate');
        $totalDisposed = DCPBatchItem::whereHas('dcpItemWarranties', function ($q) {
            $q->where('warranty_start_date', '<=', now()->subYears(5));
        })->count();
        $totalItems = DCPBatchItem::query()->count();
        $totalFunctional = max($totalItems - $totalDisposed, 0);
        $totalSchools = School::query()->count();
        $totalBatches = DCPBatch::query()->count();
        $totalItems = DCPBatchItem::query()->count();
        $totalPackages = DCPPackageTypes::query()->count();

        return response()->json([
            'total_schools' => $totalSchools,
            'total_batches' => $totalBatches,
            'total_items' => $totalItems,
            'total_packages' => $totalPackages,
            'disposed' => $totalDisposed,
            'functional' => $totalFunctional,
            'asset_value' => number_format((float) $totalAssetValue, 2, '.', ''),
            'deprecation_value' => $totalDeprecationValue,
        ]);
    }

    public function get_current_condition_of_item()
    {
        $allConditions = \App\Models\DCPCurrentCondition::all();

        $conditionCounts = DCPItemCondition::selectRaw('current_condition_id, COUNT(*) as count')
            ->groupBy('current_condition_id')
            ->pluck('count', 'current_condition_id');

        $result = $allConditions->map(function ($condition) use ($conditionCounts) {
            return [
                'id' => $condition->pk_dcp_current_conditions_id,
                'condition' => $condition->name,
                'count' => $conditionCounts->get($condition->pk_dcp_current_conditions_id, 0),
            ];
        })->values()->toArray();

        return response()->json($result);
    }

    public function showItemCondition($id)
    {
        if ($id != 0) {
            $condition = DCPItemCondition::where('current_condition_id', $id)
                ->with('dcpCurrentCondition')
                ->with('dcpBatchItem.dcpItemType')
                ->with('dcpBatchItem.dcpBatch')
                ->with('dcpBatchItem.dcpBatch.school')
                ->get();
        } else {

            $condition = DCPItemCondition::with([
                'dcpCurrentCondition',
                'dcpBatchItem.dcpItemType',
                'dcpBatchItem.dcpBatch',
                'dcpBatchItem.dcpBatch.school',
            ])
                ->get();
        }
        $condition = $condition->map(function ($item) {
            return [
                'condition_id' => $item->current_condition_id,
                'dcp_batch_item_id' => $item->dcpBatchItem->pk_dcp_batch_items_id,
                'batch_label' => $item->dcpBatchItem->dcpBatch->batch_label,
                'item_type' => $item->dcpBatchItem->dcpItemType->name,
                'school_name' => $item->dcpBatchItem->dcpBatch->school->SchoolName,
                'generated_code' => $item->dcpBatchItem->generated_code,
                'condition' => $item->dcpCurrentCondition->name,
                'updated_at' => $item->updated_at->format('F d, Y h:i A'),
            ];
        })->values()->toArray();

        return view('AdminSide.ItemConditions.show', compact('condition'));
    }

    public function itemReport($id)
    {
        $batch_item = DCPBatchItem::where('pk_dcp_batch_items_id', $id)
            ->with('dcpItemType')
            ->with('dcpBatch.school')
            ->with('dcpItemCurrentCondition.dcpCurrentCondition')
            ->first();

        return response()->json($batch_item);
    }

    public function school_with_isp()
    {

        $cctv_count = EquipmentCCTVDetails::where('school_id', '!=', null)
            ->distinct('school_id')
            ->count('school_id');
        $biometric_count = EquipmentBiometricDetails::where('school_id', '!=', null)
            ->distinct('school_id')
            ->count('school_id');

        $isp_count = ISPDetails::where('school_id', '!=', null)
            ->distinct('school_id')
            ->count('school_id');

        $school_equipment_count = SchoolEquipment::where('school_id', '!=', null)
            ->distinct('school_id')
            ->count('school_id');


        return response()->json([
            'cctv_count' => $cctv_count,
            'biometric_count' => $biometric_count,
            'isp_count' => $isp_count,
            'school_equipment_count' => $school_equipment_count
        ]);
    }

    public function get_item_categories()
    {
        $counts = DCPBatchItem::select('item_type_id')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('item_type_id')
            ->with('dcpItemType')
            ->get();

        return response()->json($counts);
    }

    public function get_package_categories()
    {
        $counts = DCPBatch::select('dcp_package_type_id')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('dcp_package_type_id')
            ->with('dcpPackageType')
            ->orderBy('total', 'desc')
            ->get();

        return response()->json($counts);
    }

    public function get_schools_dcp_count()
    {
        $count = DCPBatch::select('school_id')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('school_id')
            ->with('school')
            ->orderBy('total', 'desc')
            ->get();

        return response()->json($count);
    }
}
