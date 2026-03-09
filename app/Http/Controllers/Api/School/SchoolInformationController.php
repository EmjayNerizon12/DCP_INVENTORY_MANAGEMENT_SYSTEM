<?php

namespace App\Http\Controllers\Api\School;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $schoolId)
    {
        $schoolInformation = School::where('pk_school_id', $schoolId)->with(['schoolOfficials.schoolHead', 'schoolOfficials.ictCoordinator', 'schoolOfficials.propertyCustodian'])->get();

        return response()->json([
            'success' => true,
            'data' => $schoolInformation,
        ], 200);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
