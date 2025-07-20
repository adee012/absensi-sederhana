<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceHistory;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $employees = Employee::all();

        return view('absensi.index', compact('employees'));
    }

    public function getEmployee($employee_id)
    {
        $employee = Employee::with('departement')->where('employee_id', $employee_id)->first();

        if (!$employee) {
            return response()->json(['status' => 'error'], 404);
        }

        return response()->json([
            'status' => 'success',
            'name' => $employee->name,
            'departement' => $employee->departement->departement_name,
        ]);
    }

    public function clockIn(Request $request)
    {
        $request->validate(['employee_id' => 'required|exists:employee,employee_id']);

        $employee = Employee::with('departement')->where('employee_id', $request->employee_id)->first();
        $today = now()->toDateString();

        $existing = Attendance::where('employee_id', $employee->employee_id)
            ->whereDate('clock_in', $today)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah melakukan absen masuk hari ini.');
        }

        $now = now();
        $isLate = $now->format('H:i') > $employee->departement->max_clock_in_time;
        $description = $isLate ? 'Terlambat Masuk' : 'Tepat Waktu';
        $attendanceId = uniqid('att');

        $attendance = Attendance::create([
            'attendance_id' => $attendanceId,
            'employee_id' => $employee->employee_id,
            'clock_in' => $now,
        ]);

        AttendanceHistory::create([
            'employee_id' => $employee->employee_id,
            'attendance_id' => $attendance->attendance_id,
            'date_attendance' => $now,
            'attendance_type' => 1,
            'description' => $description,
        ]);

        return back()->with('success', 'Absensi Masuk berhasil.');
    }

    public function clockOut(Request $request)
    {
        $request->validate(['employee_id' => 'required|exists:employee,employee_id']);

        $employee = Employee::with('departement')->where('employee_id', $request->employee_id)->first();
        $today = now()->toDateString();

        $attendance = Attendance::where('employee_id', $employee->employee_id)
            ->whereDate('clock_in', $today)
            ->first();

        if (!$attendance) {
            return back()->with('error', 'Anda belum melakukan absen masuk.');
        }

        if ($attendance->clock_out) {
            return back()->with('error', 'Anda sudah melakukan absen keluar.');
        }

        // pastikan timezone sesuai
        $now = now()->setTimezone('Asia/Jakarta');

        $clockOutTime = Carbon::parse($employee->departement->max_clock_out_time)
            ->setDate($now->year, $now->month, $now->day)
            ->setTimezone('Asia/Jakarta');

        if ($now->lessThan($clockOutTime)) {
            return back()->with('error', 'Belum waktunya pulang.');
        }

        $attendance->update(['clock_out' => $now]);

        AttendanceHistory::create([
            'employee_id' => $employee->employee_id,
            'attendance_id' => $attendance->attendance_id,
            'date_attendance' => $now,
            'attendance_type' => 2,
            'description' => 'Tepat Waktu Pulang',
        ]);

        return back()->with('success', 'Absensi Keluar berhasil.');
    }
}
