<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departement = Departement::all();
        $employee = Employee::with('departement')->get();

        return view('employee.index', compact('employee', 'departement'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departements = Departement::all();
        return view('employee.create', compact('departements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'departement_id' => 'required|exists:departement,id',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('openModal', 'tambah-karyawan-modal');
        }

        // Generate employee_id otomatis
        $tanggal = now()->format('Ymd');
        $jumlahHariIni = Employee::whereDate('created_at', now()->toDateString())->count() + 1;
        $employeeId = 'emp' . $tanggal . str_pad($jumlahHariIni, 3, '0', STR_PAD_LEFT);

        Employee::create([
            'employee_id' => $employeeId,
            'departement_id' => $request->departement_id,
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return redirect('/employee')->with('success', "Karyawan berhasil ditambahkan dengan ID $employeeId");
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
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'departement_id' => 'required|exists:departement,id',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('openModal', 'edit-karyawan-modal-' . $id);
        }

        $employee = Employee::findOrFail($id);

        $employee->update([
            'departement_id' => $request->departement_id,
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return redirect()->route('employee.show')->with('success', "Data karyawan $employee->name berhasil diperbarui.");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::where('id', $id)->first();

        $name = $employee->name;

        $employee->delete();

        return back()->with('success', "Data Karyawan $name Berhasil Dihapus");
    }
}
