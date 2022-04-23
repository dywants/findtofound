<?php

namespace App\Http\Controllers;

use App\Models\Thefind;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TheFindController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return inertia::render('Pieces/TheRegister');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Thefind  $thefind
     * @return \Illuminate\Http\Response
     */
    public function show(Thefind $thefind)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Thefind  $thefind
     * @return \Illuminate\Http\Response
     */
    public function edit(Thefind $thefind)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Thefind  $thefind
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thefind $thefind)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Thefind  $thefind
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thefind $thefind)
    {
        //
    }
}
