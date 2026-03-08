<?php

namespace App\Http\Controllers;

use App\Models\DCPBatchApproval;
use Illuminate\Http\Request;

class DCPBatchApprovalController extends Controller
{
    public function submit(Request $request)
    {
        $dcp_batches_id = $request->dcp_batch_id;
        $approval = DCPBatchApproval::create([
            'dcp_batches_id' => $dcp_batches_id,
        ]);

        return redirect()->back()->with('success', "You're submission is successful, wait for the admin to be approved;");
    }
}
