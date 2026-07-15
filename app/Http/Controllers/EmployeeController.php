<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Jobrole;
use App\Services\EmployeeService;
use Exception;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'phone_number' => 'required|string',
            'place_of_birth' => 'required|string',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'id_number' => 'required|string',
            'role_id' => 'required|integer',
        ]);

        $validated['age'] = Carbon::parse($validated['date_of_birth'])->age;

        $employee = Employee::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'payload' => [
                    'statusCode' => 201,
                    'message' => 'Employee created successfully!',
                    'data' => $employee
                ]
            ], 201);
        }

        return redirect('/employees')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();

            return response()->json([
                'payload' => [
                    'statusCode' => 200,
                    'message' => 'Employee deleted successfully!',
                    'data' => [
                        'id' => $employee->id,
                        'name' => $employee->name
                    ]
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'payload' => [
                    'statusCode' => 500,
                    'message' => 'Gagal menghapus data karyawan.',
                    'error' => $e->getMessage()
                ]
            ], 500);
        }
    }

    public function show(Request $request, Employee $employee)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'payload' => [
                    'statusCode' => 200,
                    'message' => 'Employee retrieved successfully!',
                    'data' => $employee
                ]
            ], 200);
        }

        $employee->load('jobrole');
        return view('employee.detail', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $jobroles = Jobrole::orderBy('role')->get();
        return view('employee.edit', compact('employee', 'jobroles'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:employees,email,' . $employee->id,
            'phone_number'  => 'required|string|max:20',
            'place_of_birth'=> 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'address'       => 'required|string',
            'id_number'     => 'required|string|max:20',
            'role_id'       => 'required|integer|exists:job_roles,id',
            'status'        => 'required|in:active,inactive',
        ]);

        $validated['age'] = \Carbon\Carbon::parse($validated['date_of_birth'])->age;

        $employee->update($validated);

        return redirect()->route('employees.show', $employee->id)
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function indexByStatus(Request $request)
    {
        $statusFilter = $request->query('status');

        $employees = $this->employeeService->getEmployeesByStatus($statusFilter);

        return response()->json([
            'status' => 'success',
            'statusFilter' => $statusFilter,
            'employees' => $employees
        ], 200);
    }

    public function index()
    {
        $employees = Employee::all();

        return view('employee.index', compact('employees'));
    }

    public function getCashiers()
    {
        $cashierIds = DB::table('job_roles')
            ->where('role', 'cashier')
            ->pluck('id');

        $cashiers = Employee::whereIn('role_id', $cashierIds)->get();

        return response()->json([
            'status' => 'success',
            'data'   => $cashiers,
        ]);
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        if (!$handle) {
            return redirect('/employees')->with('error', 'File CSV gagal dibaca.');
        }

        $header = fgetcsv($handle);

        if (!$header) {
            fclose($handle);
            return redirect('/employees')->with('error', 'File CSV kosong atau format tidak sesuai.');
        }

        $header = array_map(function ($value) {
            return strtolower(trim($value));
        }, $header);

        $success = 0;
        $failed = 0;
        $skipped = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);

            if (!$data) {
                $failed++;
                continue;
            }

            $name = trim($data['name'] ?? '');
            $email = trim($data['email'] ?? '');
            $phoneNumber = trim($data['phone_number'] ?? '');
            $placeOfBirth = trim($data['place_of_birth'] ?? '');
            $dateOfBirth = trim($data['date_of_birth'] ?? '');
            $address = trim($data['address'] ?? '');
            $idNumber = trim($data['id_number'] ?? '');
            $roleId = trim($data['role_id'] ?? '');
            $status = trim($data['status'] ?? 'active');

            if (
                empty($name) ||
                empty($email) ||
                empty($phoneNumber) ||
                empty($placeOfBirth) ||
                empty($dateOfBirth) ||
                empty($address) ||
                empty($idNumber) ||
                empty($roleId)
            ) {
                $failed++;
                continue;
            }

            if (Employee::where('email', $email)->exists()) {
                $skipped++;
                continue;
            }

            try {
                $age = Carbon::parse($dateOfBirth)->age;

                Employee::create([
                    'name' => $name,
                    'email' => $email,
                    'phone_number' => $phoneNumber,
                    'place_of_birth' => $placeOfBirth,
                    'date_of_birth' => $dateOfBirth,
                    'address' => $address,
                    'id_number' => $idNumber,
                    'age' => $age,
                    'role_id' => $roleId,
                    'status' => $status ?: 'active',
                ]);

                $success++;
            } catch (Exception $e) {
                $failed++;
            }
        }

        fclose($handle);

        return redirect('/employees')->with(
            'success',
            "Import selesai. Berhasil: $success data, dilewati karena email sudah ada: $skipped data, gagal: $failed data."
        );
    }
}