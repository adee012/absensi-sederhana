<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departement = Departement::all();

        return view('departement.index', compact('departement'));
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
        $validator = Validator::make($request->all(), [
            'departement_name' => 'required|unique:departement,departement_name',
            'max_clock_in_time' => 'required|date_format:H:i',
            'max_clock_out_time' => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $dpt = Departement::create([
            'departement_name' => $request->departement_name,
            'max_clock_in_time' => $request->max_clock_in_time,
            'max_clock_out_time' => $request->max_clock_out_time,
        ]);

        return redirect('departement')->with('success', "Departement $dpt->departement_name berhasil ditambahkan");
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $departement = Departement::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'departement_name' => 'required|unique:departement,departement_name,' . $id,
            'max_clock_in_time' => 'required|date_format:H:i',
            'max_clock_out_time' => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('edit-departement-id', $id);
        }

        $departement->update([
            'departement_name' => $request->departement_name,
            'max_clock_in_time' => $request->max_clock_in_time,
            'max_clock_out_time' => $request->max_clock_out_time,
        ]);

        return back()->with('success', "Departement {$departement->departement_name} berhasil diubah.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $departement = Departement::where('id', $id)->first();

        $name = $departement->departement_name;

        $departement->delete();

        return back()->with('success', "Departement $name berhasil dihapus");
    }
}
