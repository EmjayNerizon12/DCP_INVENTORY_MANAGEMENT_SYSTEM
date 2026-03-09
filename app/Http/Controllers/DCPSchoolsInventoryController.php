<?php

namespace App\Http\Controllers;

use App\Models\DCPBatch;
use App\Models\DCPBatchItem;
use App\Models\School;
use Illuminate\Http\Request;

class DCPSchoolsInventoryController extends Controller
{
    public function index()
    {

        $school_items = DCPBatchItem::all()->groupBy('dcp_batch_id');

        return view('AdminSide.SchoolsInventory.inventory', compact('school_items'));
    }

    public function inventory(Request $request)
    {
        $schools = School::all();
        $selectedSchool = $request->input('school');
        $selectedBudgetYear = $request->input('budget_year');

        // Get distinct budget years from DCPBatch
        $budgetYears = DCPBatch::select('budget_year')
            ->distinct()
            ->orderByDesc('budget_year')
            ->pluck('budget_year');

        $school_items = collect(); // always initialize

        // Build query conditionally
        $query = DCPBatch::with('dcpBatchItems', 'school');

        if ($selectedSchool) {
            $query->where('school_id', $selectedSchool);
        }

        if ($selectedBudgetYear) {
            $query->where('budget_year', $selectedBudgetYear);
        }

        $batches = $query->get();

        $school_items_count = $batches->map(function ($batch) {
            return [
                'batch_label' => $batch->batch_label,
                'school_name' => $batch->school->SchoolName ?? 'Unknown',
                'items' => $batch->dcpBatchItems ?? collect(), // fallback to empty collection
            ];
        });
        // dd($school_items);
        $school_items = $query->orderBy('budget_year', 'desc')->paginate(10);

        // dd($school_items);
        return view('AdminSide.SchoolsInventory.inventory', compact(
            'schools',
            'school_items',
            'selectedSchool',
            'school_items_count',
            'budgetYears',
            'selectedBudgetYear'
        ));
    }

    public function showItems($code)
    {
        $items = DCPBatchItem::where('generated_code', $code)->get();

        $batch = DCPBatch::where('pk_dcp_batches_id', $items[0]->dcp_batch_id)->first();
        $schoolName = School::where('pk_school_id', $batch->school_id)->value('SchoolName');
        $batchName = $batch->batch_label;
        $school_pk = $batch->school_id;

        return view('AdminSide.SchoolsInventory.inventory-item', compact('school_pk', 'items', 'batchName', 'schoolName'));
    }
}
