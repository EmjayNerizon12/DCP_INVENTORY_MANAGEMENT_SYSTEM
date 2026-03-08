<?php

namespace App\Http\Controllers;

use App\Models\NonDCPItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolNonDCPItemController extends Controller
{
    public function index()
    {
        $non_dcp = NonDCPItem::with('fund_source')->where('school_id', Auth::guard('school')->user()->school->pk_school_id)->get();

        return view('SchoolSide.NonDCP.index', compact('non_dcp'));
    }

    public function store(Request $request)
    {
        $request->validate([

            'item_description' => 'required|string',
            'total_item' => 'required|integer',
            'total_functional' => 'required|integer',
            'unit_price' => 'required|numeric',
            'date_acquired' => 'required|date',
            'fund_source_id' => 'required|exists:fund_source,pk_fund_source_id',
            'item_holder_and_location' => 'required|string',
            'remarks' => 'nullable|string',
        ]);
        $request->merge(['school_id' => Auth::guard('school')->user()->school->pk_school_id]);

        NonDCPItem::create($request->all());

        return redirect()->back()->with('success', 'Non-DCP Item added successfully.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'pk_non_dcp_item_id' => 'required|exists:non_dcp_item,pk_non_dcp_item_id',
            'item_description' => 'required|string',
            'total_item' => 'required|integer',
            'total_functional' => 'required|integer',
            'unit_price' => 'required|numeric',
            'date_acquired' => 'required|date',
            'fund_source_id' => 'required|exists:fund_source,pk_fund_source_id',
            'item_holder_and_location' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        $nondcp = NonDCPItem::find($request->pk_non_dcp_item_id);
        $nondcp->update($request->all());

        return redirect()->back()->with('success', 'Non-DCP Item updated successfully.');
    }

    public function delete(int $id)
    {
        $nondcp = NonDCPItem::find($id);
        if ($nondcp) {
            $nondcp->delete();

            return response()->json(['success' => 'Non-DCP Item deleted successfully.']);
        } else {
            return response()->json(['error' => 'Non-DCP Item not found.'], 404);
        }
    }
}
