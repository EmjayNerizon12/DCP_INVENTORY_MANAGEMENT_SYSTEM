<?php

namespace App\Http\Controllers\SchoolEquipment;

use App\Http\Controllers\Controller;
use App\Models\SchoolEquipment\SchoolEquipmentCondition;
use Illuminate\Http\Request;

class SchoolEquipmentConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SchoolEquipmentCondition::all();
        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No data found',
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolEquipmentCondition $schoolEquipmentCondition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolEquipmentCondition $schoolEquipmentCondition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolEquipmentCondition $schoolEquipmentCondition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolEquipmentCondition $schoolEquipmentCondition)
    {
        //
    }
}
