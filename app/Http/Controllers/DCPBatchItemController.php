<?php

namespace App\Http\Controllers;

use App\Models\DCPBatch;
use App\Models\DCPBatchItem;
use App\Models\DCPDeliveryCondintion;
use App\Models\DCPItemTypes;
use App\Models\DCPPackageTypes;
use App\Models\School;
use Illuminate\Http\Request;

class DCPBatchItemController extends Controller
{
    public function index($batchId)
    {
        $batch = DCPBatch::findOrFail($batchId);
        $items = DCPBatchItem::where('dcp_batch_id', $batchId)->get();
        $itemTypes = DCPItemTypes::all();
        $conditions = DCPDeliveryCondintion::all();

        return view('AdminSide.DCPBatch.Items', compact('batch', 'items', 'itemTypes', 'conditions'));
    }

    public function store(Request $request, $batchId)
    {
        $validated = $request->validate([
            'item_type_id' => 'required|integer',
            'quantity' => 'required|integer',
            'unit' => 'required|string|max:50',
            'condition_id' => 'integer|nullable',

        ]);

        $batch = DCPBatch::findOrFail($batchId);
        $packageType = DCPPackageTypes::findOrFail($batch->dcp_package_type_id);
        $itemType = DCPItemTypes::findOrFail($validated['item_type_id']);
        $school = School::findOrFail($batch->school_id);

        $schoolLevel = $school->SchoolLevel;
        if ($schoolLevel === 'Elementary School' || $schoolLevel === 'Elementary') {
            $schoolLevel = 'Elementary';
        } elseif ($schoolLevel === 'Junior High School' || $schoolLevel === 'JHS') {
            $schoolLevel = 'JHS';
        } elseif ($schoolLevel === 'Senior High School' || $schoolLevel === 'SHS') {
            $schoolLevel = 'SHS';
        } else {
            $schoolLevel = 'Unknown'; // Handle unexpected school levels
        }

        $deliveryDate = \Carbon\Carbon::parse($batch->delivery_date)->format('mdy');

        // Generate the code prefix (without the count)
        $codePrefix = "{$batch->batch_label}-{$packageType->code}-{$itemType->code}-{$schoolLevel}-{$school->SchoolID}-{$deliveryDate}-";

        // Find the latest count for this prefix
        $latestItem = DCPBatchItem::where('generated_code', 'like', $codePrefix.'%')
            ->orderByDesc('generated_code')
            ->first();

        if ($latestItem) {
            $lastCount = (int) substr($latestItem->generated_code, -5);
        } else {
            $lastCount = 0;
        }

        // Create the specified quantity of items
        for ($i = 1; $i <= $validated['quantity']; $i++) {
            $itemCountPadded = str_pad($lastCount + $i, 5, '0', STR_PAD_LEFT);
            $generatedCode = $codePrefix.$itemCountPadded;

            $itemData = $validated;
            $itemData['generated_code'] = $generatedCode;
            $itemData['dcp_batch_id'] = $batchId;
            $itemData['quantity'] = 1; // Each record is for 1 item

            DCPBatchItem::create($itemData);
        }

        return response()->json([
            'success' => true,
            'message' => 'Items added successfully',
            'pk_dcp_batch_id' => $batch->pk_dcp_batches_id,
            'data' => [
                'batch_label' => $batch->batch_label,
                'item_type' => $itemType->name,
                'quantity' => $validated['quantity'],
                'unit' => $validated['unit'],
                'condition_id' => $validated['condition_id'],
            ],
        ]);
    }

    public function itemsJson($batchId)
    {
        $items = DCPBatchItem::where('dcp_batch_id', $batchId)
            ->join('dcp_item_types', 'dcp_batch_items.item_type_id', '=', 'dcp_item_types.pk_dcp_item_types_id')
            ->leftJoin('dcp_delivery_conditions', 'dcp_batch_items.condition_id', '=', 'dcp_delivery_conditions.pk_dcp_delivery_conditions_id')
            ->select(
                'dcp_batch_items.*',
                'dcp_item_types.name as type_name',
                'dcp_delivery_conditions.name as condition_name'
            )
            ->get();

        return response()->json(['items' => $items]);
    }

    public function clear($batchId)
    {
        $batch = DCPBatch::findOrFail($batchId);
        $items = DCPBatchItem::where('dcp_batch_id', $batchId)->get();

        if ($items->isEmpty()) {
            return response()->json(['message' => 'No items to clear'], 404);
        }

        foreach ($items as $item) {
            $item->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Items cleared successfully',
        ]);
    }
}
