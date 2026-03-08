<?php

namespace App\Http\Controllers;

use App\Models\DCPBatch;
use App\Models\DCPCurrentCondition;
use App\Models\Equipment\EquipmentBiometricDetails;
use App\Models\Equipment\EquipmentCCTVDetails;
use App\Models\ISP\ISPDetails;
use App\Models\NonDCPItem;
use App\Models\SchoolData;
use Illuminate\Support\Facades\Auth;

class SchoolReportController extends Controller
{
    public function index()
    {
        $school_id = Auth::guard('school')->user()->school->pk_school_id;
        $batch = DCPBatch::where('school_id', $school_id)->orderBy('delivery_date', 'asc')->get();

        $ISP = ISPDetails::where('school_id', $school_id)->get();
        $CCTVDetails = EquipmentCCTVDetails::where('school_id', $school_id)->get();
        $BiometricDetails = EquipmentBiometricDetails::where('school_id', $school_id)->get();
        $batches = DCPBatch::where('school_id', $school_id)->orderBy('delivery_date', 'asc')->get();
        $total_batches = DCPBatch::where('school_id', $school_id)->count();
        $non_dcp = NonDCPItem::with('fund_source')->where('school_id', Auth::guard('school')->user()->school->pk_school_id)->get();

        // $total_classrooms = SchoolData::where('pk_school_id', $school_id)->value('total_classrooms')->count;
        return view('SchoolSide.Report.index', compact('batch', 'ISP', 'CCTVDetails', 'BiometricDetails', 'batches', 'total_batches', 'non_dcp'));
    }

    public function condition_report(int $condition_id)
    {
        $school_id = Auth::guard('school')->user()->school->pk_school_id;
        $batch_items = DCPBatch::where('school_id', $school_id)
            ->with(['dcpBatchItems' => function ($query) use ($condition_id) {
                $query->whereHas('dcpItemCurrentCondition', function ($q) use ($condition_id) {
                    $q->where('current_condition_id', $condition_id);
                })
                    ->with([
                        'dcpItemCurrentCondition.dcpCurrentCondition', // for condition name
                        'dcpItemType', // for item type name
                        'brand_details',
                    ]);
            }])
            ->orderBy('delivery_date', 'desc')
            ->get();
        $condition_name = DCPCurrentCondition::where('pk_dcp_current_conditions_id', $condition_id)->first()->name;

        return response()->json([
            'status' => 'success',
            'current_condition' => $condition_name,
            'data' => $batch_items,
        ]);
    }

    public function condition()
    {
        return view('SchoolSide.Report.condition');
    }
}
