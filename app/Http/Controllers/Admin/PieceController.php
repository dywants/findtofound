<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Piece;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PieceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $pieces = Piece::latest()->get();

        return Inertia::render('Admin/Pieces/Index', [
            'pieces' => $pieces
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
       return Inertia::render('Admin/Pieces/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->getValidate($request);

        Piece::create($request->all());
        $request->session()->flash('success', 'Piece created successfully!');

        return redirect()->route('piece.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Piece  $piece
     * @return \Illuminate\Http\Response
     */
    public function show(Piece $piece)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Piece  $piece
     * @return \Inertia\Response
     */
    public function edit(Piece $piece)
    {
       return Inertia::render('Admin/Pieces/Edit', [
           'piece' => $piece
       ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Piece  $piece
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Piece $piece)
    {
        $this->getValidate($request, $piece->id);
        $piece->update($request->all());
        $request->session()->flash('success', 'Piece updated successfully!');

        return redirect()->route('piece.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Piece  $piece
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request,Piece $piece)
    {
        $piece->delete();
        $request->session()->flash('success', 'Pièce deleted successfully!');
        return redirect()->route('piece.index');
    }

    private function getValidate(Request $request, $id = null): void
    {
        $data = [
            'name' => 'required',
            'amount' => 'required'
        ];
        $this->validate($request, $data);
    }
}
