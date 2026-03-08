<?php

namespace App\Http\Controllers\SchoolEquipment;

use App\Http\Controllers\Controller;
use App\Models\SchoolEquipment\SchoolEquipmentTransactionType;
use Illuminate\Http\Request;

class SchoolEquipmentTransactionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SchoolEquipmentTransactionType::all();

        return response()->json(['success' => true, 'data' => $data]);
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
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(SchoolEquipmentTransactionType $schoolEquipmentTransactionType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolEquipmentTransactionType $schoolEquipmentTransactionType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolEquipmentTransactionType $schoolEquipmentTransactionType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolEquipmentTransactionType $schoolEquipmentTransactionType)
    {
        //
    }
}
