<?php

namespace App\Http\Controllers;

use App\Models\DCPBatchItem;
use Illuminate\Http\Request;

class CameraScanController extends Controller
{
    public function updateStatus(Request $request)
    {

        $validated = $request->validate([
            'code' => 'required|string',
        ]);
        $item = DCPBatchItem::where('generated_code', $validated['code'])->first();
        if (! $item) {
            return response()->json(['message' => 'Item not found.'], 500);
        }
        $item_update = $item->update([
            'monitored' => 1,
        ]);
        if (! $item_update) {
            return response()->json(['message' => 'Failed to update item status.'], 500);
        }
        // Here you would typically update the item's status in the database.
        // For demonstration, we'll just return a success response.

        return response()->json(['message' => 'Item status updated successfully.']);
    }
}
