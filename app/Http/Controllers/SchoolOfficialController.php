<?php

namespace App\Http\Controllers;

use App\Models\SchoolOfficial;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SchoolOfficialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        try {
            $validated = $request->validate([
                'school_id' => 'required',
                'school_head' => 'required',
                'ict_coordinator' => 'required',
                'property_custodian' => 'required',
            ]);
            SchoolOfficial::updateOrCreate(
                ['school_id' => $validated['school_id']],
                $validated
            );

            return response()->json([
                'success' => true,
                'message' => 'Saved successfully',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => true,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolOfficial $schoolOfficial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolOfficial $schoolOfficial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolOfficial $schoolOfficial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolOfficial $schoolOfficial)
    {
        //
    }
}
