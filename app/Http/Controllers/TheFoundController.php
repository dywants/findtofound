<?php

namespace App\Http\Controllers;

use App\Models\Thefind;
use App\Models\TheFound;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class TheFoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
       return inertia::render('Pieces/TheSearch');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Thefind $theFound
     * @return Response
     */
    public function show(Thefind $theFound)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TheFound $theFound
     * @return Response
     */
    public function edit(Thefind $theFound)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Thefind $theFound
     * @return Response
     */
    public function update(Request $request, Thefind $theFound)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Thefind $theFound
     * @return Response
     */
    public function destroy(Thefind $theFound)
    {
        //
    }
}
