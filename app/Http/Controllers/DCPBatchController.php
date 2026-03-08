<?php

namespace App\Http\Controllers;

use App\Models\DCPBatch;
use App\Models\DCPBatchApproval;
use App\Models\DCPBatchItem;
use App\Models\DCPBatchItemBrand;
use App\Models\DCPItemTypes;
use App\Models\DCPItemWarrantyStatus;
use App\Models\DCPPackageContent;
use App\Models\DCPPackageTypes;
use App\Models\School;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DCPBatchController extends Controller
{
    public function listJson(Request $request)
    {
        $perPage = (int) $request->query('per_page', 20);
        if ($perPage <= 0) $perPage = 20;
        if ($perPage > 100) $perPage = 100;

        $queryText = trim((string) $request->query('q', ''));

        $query = DB::table('dcp_batches')
            ->join('dcp_package_types', 'dcp_batches.dcp_package_type_id', '=', 'dcp_package_types.pk_dcp_package_types_id')
            ->join('schools', 'dcp_batches.school_id', '=', 'schools.pk_school_id')
            ->leftJoin('dcp_batch_approval', 'dcp_batch_approval.dcp_batches_id', '=', 'dcp_batches.pk_dcp_batches_id')
            ->select(
                'dcp_batches.pk_dcp_batches_id as id',
                'dcp_batches.batch_label',
                'dcp_batches.description',
                'dcp_batches.budget_year',
                'dcp_batches.delivery_date',
                'dcp_batches.supplier_name',
                'dcp_batches.mode_of_delivery',
                'dcp_batches.submission_status',
                'dcp_batches.date_approved',
                'dcp_batches.school_id',
                'dcp_batches.dcp_package_type_id',
                'dcp_package_types.name as package_type_name',
                'schools.SchoolName as school_name',
                'schools.SchoolLevel as school_level',
                'schools.SchoolID as school_code',
                'dcp_batch_approval.status as approval_status'
            )
            ->orderBy('dcp_batches.delivery_date', 'desc');

        if ($queryText !== '') {
            $query->where(function ($q) use ($queryText) {
                $q->where('dcp_batches.batch_label', 'like', "%{$queryText}%")
                    ->orWhere('dcp_batches.description', 'like', "%{$queryText}%")
                    ->orWhere('schools.SchoolName', 'like', "%{$queryText}%")
                    ->orWhere('schools.SchoolLevel', 'like', "%{$queryText}%")
                    ->orWhere('dcp_batches.budget_year', 'like', "%{$queryText}%");
            });
        }

        $paginator = $query->paginate($perPage)->withQueryString();

        $batches = collect($paginator->items())->map(function ($item) {
            $deliveryDateRaw = $item->delivery_date;
            $deliveryDateFormatted = null;

            if ($deliveryDateRaw) {
                try {
                    $deliveryDateFormatted = Carbon::parse($deliveryDateRaw)->format('F d, Y');
                } catch (\Throwable $e) {
                    $deliveryDateFormatted = (string) $deliveryDateRaw;
                }
            }

            return [
                'id' => (int) $item->id,
                'batch_label' => $item->batch_label,
                'description' => $item->description,
                'budget_year' => $item->budget_year,
                'delivery_date' => $item->delivery_date,
                'delivery_date_formatted' => $deliveryDateFormatted,
                'supplier_name' => $item->supplier_name,
                'mode_of_delivery' => $item->mode_of_delivery,
                'submission_status' => $item->submission_status,
                'date_approved' => $item->date_approved,
                'approval_status' => $item->approval_status,
                'package_type_name' => $item->package_type_name,
                'dcp_package_type_id' => $item->dcp_package_type_id,
                'school_id' => $item->school_id,
                'school_name' => $item->school_name,
                'school_level' => $item->school_level,
                'school_code' => $item->school_code,
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data' => [
                'batches' => $batches,
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                    'from' => $paginator->firstItem(),
                    'to' => $paginator->lastItem(),
                ],
            ],
        ]);
    }

    public function getSchoolsWithPackages()
    {
        $schools = School::with(['dcpBatches.dcpBatchItems'])
            ->withCount('dcpBatches')
            ->orderBy('SchoolName')
            ->get();

        $result = $schools->map(function ($school) {
            // Compute total cost for this school
            $totalCost = $school->dcpBatches
                ->flatMap->dcpBatchItems
                ->sum(function ($item) {
                    return floatval($item->unit_price ?? 0);
                });

            return [
                'SchoolName' => $school->SchoolName,
                'SchoolLevel' => $school->SchoolLevel,
                'TotalBatch' => $school->dcp_batches_count ?? 0,
                'TotalCost' => $totalCost,
            ];
        });

        // Compute overall total across all schools
        $overallTotal = $result->sum('TotalCost');

        return response()->json([
            'schools' => $result,
            'overall_total_cost' => $overallTotal,
        ]);
    }

    public function approve(Request $request, $id)
    {
        $batch = DCPBatch::findOrFail($id);
        $batch->submission_status = 'Approved';
        $batch->date_approved = now()->format('Y-m-d');
        $batch->update();

        // Also update all related DCPBatchItem date_approved fields
        DCPBatchItem::where('dcp_batch_id', $batch->pk_dcp_batches_id ?? $batch->id)
            ->update(['date_approved' => $batch->date_approved]);
        DCPBatchApproval::where('dcp_batches_id', $batch->pk_dcp_batches_id ?? '')
            ->update(['status' => 'Approved']);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'DCP Batch approved successfully!',
            ]);
        }

        return redirect()->back()->with('success', 'DCP Batch approved successfully!');
    }

    public function index()
    {
        $packageTypes = DCPPackageTypes::all();

        $schools = School::all();
        $total_pending = DCPBatchApproval::where('status', 'Pending')->count();
        $total_approved = DCPBatchApproval::where('status', 'Approved')->count();
        $total_batches = DCPBatch::all()->count();
        $total_unsubmitted = DCPBatch::doesntHave('approval')->count();

        return view('AdminSide.DCPBatch.Batch', compact('packageTypes', 'schools', 'total_pending', 'total_approved', 'total_batches', 'total_unsubmitted'));
    }

    public function store(Request $request)
    {
	        $validator = Validator::make($request->all(), [
	            'dcp_package_type_id' => 'required|integer|exists:dcp_package_types,pk_dcp_package_types_id',
	            'school_id' => 'nullable|integer|exists:schools,pk_school_id',
	            'batch_label' => 'required|string|max:255',
	            'description' => 'nullable|string',
	            'budget_year' => 'required|integer',
	            'delivery_date' => 'required|date',
	            'supplier_name' => 'required|string|max:255',
	            'mode_of_delivery' => 'required|string|max:255',
	        ]);
        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $batch = DCPBatch::create($validator->validated());

        $contents = DCPPackageContent::where('dcp_package_types_id', $batch->dcp_package_type_id)->get();

        foreach ($contents as $content) {
            $this->storeBatchItem($batch->pk_dcp_batches_id, $content); // ✅ calling the method
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'DCP Batch created successfully!',
                'data' => [
                    'id' => $batch->pk_dcp_batches_id,
                    'batch_label' => $batch->batch_label,
                ],
            ], 201);
        }

        return redirect()->back()->with('success', 'DCP Batch created successfully!');
    }

    public function update(Request $request)
    {
	        $validator = Validator::make($request->all(), [
	            'id' => 'required|integer|exists:dcp_batches,pk_dcp_batches_id',
	            'dcp_package_type_id' => 'required|integer|exists:dcp_package_types,pk_dcp_package_types_id',
	            'school_id' => 'nullable|integer|exists:schools,pk_school_id',
	            'batch_label' => 'required|string|max:255',
	            'description' => 'nullable|string',
	            'budget_year' => 'required|integer',
	            'delivery_date' => 'required|date',
	            'supplier_name' => 'required|string|max:255',
	            'mode_of_delivery' => 'required|string|max:255',
	        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $batch = DCPBatch::findOrFail($data['id']);
        unset($data['id']);
        $batch->update($data);

        return response()->json([
            'success' => true,
            'message' => 'DCP Batch updated successfully!',
            'data' => [
                'id' => $batch->pk_dcp_batches_id,
            ],
        ]);
    }

    public function storeBatchItem($batchId, DCPPackageContent $packageContent)
    {

        $batch = DCPBatch::findOrFail($batchId);
        $packageType = DCPPackageTypes::findOrFail($batch->dcp_package_type_id);
        $itemType = DCPItemTypes::findOrFail($packageContent->dcp_item_types_id);
        $brand = DCPBatchItemBrand::findOrFail($packageContent->dcp_batch_item_brands_id);
        $school = School::findOrFail($batch->school_id);

        // Normalize school level
        $schoolLevel = match ($school->SchoolLevel) {
            'Elementary School', 'ELEM' => 'ELEM',
            'Junior High School', 'JHS' => 'JHS',
            'Senior High School', 'SHS' => 'SHS',
            default => 'Unknown',
        };

        $deliveryDate = Carbon::parse($batch->delivery_date)->format('mdy');

        // Build code prefix
        $codePrefix = "DCP{$batch->budget_year}-{$packageType->code}-{$itemType->code}-{$schoolLevel}-{$school->SchoolID}-{$deliveryDate}-";

        // Get latest code count for this prefix
        $latestItem = DCPBatchItem::where('generated_code', 'like', $codePrefix.'%')
            ->orderByDesc('generated_code')
            ->first();

        $lastCount = $latestItem ? (int) substr($latestItem->generated_code, -5) : 0;

        // Loop based on quantity in package content
        for ($i = 1; $i <= $packageContent->quantity; $i++) {
            $itemCountPadded = str_pad($lastCount + $i, 5, '0', STR_PAD_LEFT);
            $generatedCode = $codePrefix.$itemCountPadded;

            $batchItem = DCPBatchItem::create([
                'dcp_batch_id' => $batch->pk_dcp_batches_id,
                'item_type_id' => $itemType->pk_dcp_item_types_id,
                'generated_code' => $generatedCode,
                'unit_price' => $packageContent->unit_price,
                'unit' => 'unit ',
                'brand' => $brand->pk_dcp_batch_item_brands_id,
                'quantity' => 1,
            ]);
            DCPItemWarrantyStatus::create([
                'dcp_batch_item_id' => $batchItem->pk_dcp_batch_items_id,
                'warranty_start_date' => $batch->delivery_date,
                'warranty_end_date' => Carbon::parse($batch->delivery_date)->addYears(3)->toDateString(),
                'warranty_contract' => 'Standard 3-Year Warranty',
                'warranty_remaining' => '3 years',
                'warranty_status_id' => 1, // assuming 1 = "Active"
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "{$packageContent->quantity} items created from package content.",
            'data' => [
                'batch_label' => $batch->batch_label,
                'package_type' => $packageType->name,
                'item_type' => $itemType->name,
                'quantity' => $packageContent->quantity,
            ],
        ]);
    }

    public function destroy($batchId)
    {
        $batch = DCPBatch::findOrFail($batchId);
        $batch->delete();

        return response()->json([
            'success' => true,
            'message' => 'DCP Batch deleted successfully!',
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $dcpBatches = DB::table('dcp_batches')
            ->join('dcp_package_types', 'dcp_batches.dcp_package_type_id', '=', 'dcp_package_types.pk_dcp_package_types_id')
            ->join('schools', 'dcp_batches.school_id', '=', 'schools.pk_school_id')
            ->leftJoin('dcp_batch_approval', 'dcp_batch_approval.dcp_batches_id', '=', 'dcp_batches.pk_dcp_batches_id')
            ->select(
                'dcp_batches.*',
                'dcp_package_types.name as package_type_name',
                'schools.SchoolName as school_name',
                'schools.SchoolLevel as school_level',
                'schools.SchoolID as school_id',
                'dcp_batch_approval.status as approval_status'
            )
            ->where(function ($q) use ($query) {
                $q->where('batch_label', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhere('schools.SchoolName', 'like', "%{$query}%")
                    ->orWhere('budget_year', 'like', "%{$query}%");
            })
            ->get();

        // Format delivery_date
        $dcpBatches->transform(function ($item) {
            $item->delivery_date = $item->delivery_date
                ? \Carbon\Carbon::parse($item->delivery_date)->format('F d, Y')
                : null;

            return $item;
        });

        return response()->json($dcpBatches);
    }
}
