<?php

namespace App\Http\Controllers\ISPQ;

use App\Http\Controllers\Controller;
use App\Models\ISPQ\ISPQuestion;
use Illuminate\Http\Request;

class ISPQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $i_s_p_questions = ISPQuestion::all();

        return $i_s_p_questions;
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
    public function show(ISPQuestion $iSPQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ISPQuestion $iSPQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ISPQuestion $iSPQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ISPQuestion $iSPQuestion)
    {
        //
    }
}
