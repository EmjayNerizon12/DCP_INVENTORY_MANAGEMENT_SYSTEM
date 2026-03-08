<?php

namespace App\Http\Controllers;

use App\Models\DCPBatch;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        return view('AdminSide.Reports.index');
    }

    public function generateReport()
    {
        // Logic to generate report based on request parameters
        $schools = School::with(['dcpBatches.dcpBatchItems.dcpItemType'])
            ->get()
            ->map(function ($school) {
                // Group each batch's items by item type
                $school->dcpBatches = $school->dcpBatches->map(function ($batch) {
                    $batch->grouped_items = $batch->dcpBatchItems->groupBy(function ($item) {
                        return $item->dcpItemType->name ?? 'Unknown Type';
                    });

                    return $batch;
                });

                return $school;
            })
            ->sortBy('SchoolName') // sort alphabetically
            ->values();

        // $batches = DCPBatch::select('school_id', DB::raw('COUNT(*) as total_batches'))
        //     ->groupBy('school_id')
        //     ->get();
        // $schoolIdsWithBatches = DCPBatch::pluck('school_id')->unique();
        // $schoolsWithoutBatches = School::whereNotIn('pk_school_id', $schoolIdsWithBatches)->get();
        // return response()->json([
        //     'success' => true,
        //     'schools_without_batches' => $schoolsWithoutBatches
        // ]);
        // Example of fetching data
        // Process the data and generate the report
        return response()->json(['success' => true, 'data' => $schools]);
    }

    public function totalCost()
    {
        // $overallTotal = School::with(['dcpBatches.dcpBatchItems'])
        //     ->get()
        //     ->flatMap->dcpBatches
        //     ->flatMap->dcpBatchItems
        //     ->sum(function ($item) {
        //         return floatval($item->unit_price ?? 0);
        //     });

        // return $overallTotal;
        $schools = School::with(['dcpBatches.dcpBatchItems.dcpItemType'])
            ->get()
            ->map(function ($school) {
                $overallTotal = 0;

                foreach ($school->dcpBatches as $batch) {
                    foreach ($batch->dcpBatchItems as $item) {
                        $price = floatval($item->unit_price ?? 0);
                        $overallTotal += $price; // 1 item per record
                    }
                }

                return [
                    'SchoolID' => $school->pk_school_id,
                    'SchoolName' => $school->SchoolName,
                    'SchoolLevel' => $school->SchoolLevel,
                    'OverallTotalCost' => $overallTotal,
                ];
            })
            ->sortBy('SchoolName')
            ->values();

        return response()->json(['success' => true, 'data' => $schools]);
    }
}
