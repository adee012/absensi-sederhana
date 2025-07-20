<?php

namespace App\Http\Controllers;

use App\Models\AttendanceHistory;
use App\Models\Departement;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceHistoryController extends Controller
{
    public function index(Request $request)
    {
        $departementId = $request->departement_id;
        $date = $request->date;

        $histories = AttendanceHistory::with(['employee', 'employee.departement'])
            ->when($departementId, function ($query) use ($departementId) {
                $query->whereHas('employee', function ($q) use ($departementId) {
                    $q->where('departement_id', $departementId);
                });
            })
            ->when($date, function ($query) use ($date) {
                $query->whereDate('date_attendance', Carbon::parse($date)->format('Y-m-d'));
            })
            ->latest()
            ->get();

        $departements = Departement::all();

        return view('history.index', compact('histories', 'departements', 'departementId', 'date'));
    }
}
