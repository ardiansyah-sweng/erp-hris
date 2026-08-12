<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\PerformanceEvaluation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AllObserversAuditLogTest extends TestCase
{
    // Sengaja TIDAK pakai RefreshDatabase — data hasil test ini memang mau
    // tetap muncul di halaman UI setelah test selesai jalan.
    use RefreshDatabase;

    protected $testUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testUser = User::firstOrCreate(
            ['email' => 'tester@erphris.com'],
            [
                'name'     => 'Tester ERP HRIS',
                'password' => bcrypt('password'),
            ]
        );

        $this->actingAs($this->testUser);
    }

    protected function createFullEmployee($name, $email, $phone)
    {
        $suffix = uniqid();

        [$localPart, $domain] = array_pad(explode('@', $email, 2), 2, 'erphris.com');
        $uniqueEmail = "{$localPart}+{$suffix}@{$domain}";

        $uniqueIdNumber = '317' . substr(str_pad((string) (crc32($suffix)), 13, '0', STR_PAD_LEFT), 0, 13);

        return Employee::create([
            'name'           => $name,
            'email'          => $uniqueEmail,
            'phone_number'   => $phone,
            'place_of_birth' => 'Jakarta',
            'date_of_birth'  => '2000-01-01',
            'address'        => 'Jl. Testing No. 123',
            'id_number'      => $uniqueIdNumber,
            'age'            => 26,
            'role_id'        => 1,
            'status'         => 'active',
        ]);
    }

    /** TEST 1: OBSERVER KARYAWAN (EMPLOYEE) */
    public function test_employee_observer_logs_all_actions()
    {
        $employee = $this->createFullEmployee('Karyawan Uji Coba', 'karyawan.test@erphris.com', '081234567890');

        $this->assertDatabaseHas('activity_logs', [
            'user_email' => 'tester@erphris.com',
            'action'     => 'CREATE',
            'module'     => 'Employee',
        ]);

        $employee->update(['name' => 'Karyawan Sukses Diubah']);
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'UPDATE',
            'module' => 'Employee',
        ]);

        $employee->delete();
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'DELETE',
            'module' => 'Employee',
        ]);
    }

    /** TEST 2: OBSERVER ABSENSI (ATTENDANCE) */
    public function test_attendance_observer_logs_all_actions()
    {
        $employee = $this->createFullEmployee('Helper Employee', 'helper@erphris.com', '081234567891');

        // ENUM valid sesuai migration: ['present', 'absent', 'late', 'sick', 'leave']
        $attendance = Attendance::create([
            'employee_id' => $employee->id,
            'date'        => now()->format('Y-m-d'),
            'status'      => 'present',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'CREATE',
            'module' => 'Attendance',
        ]);

        $attendance->update(['status' => 'leave']);
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'UPDATE',
            'module' => 'Attendance',
        ]);
    }

    /** TEST 3: OBSERVER CUTI (LEAVE REQUEST) */
    public function test_leave_request_observer_logs_all_actions()
    {
        $employee = $this->createFullEmployee('Helper Employee Leave', 'helper.leave@erphris.com', '081234567892');

        $leave = LeaveRequest::create([
            'employee_id'     => $employee->id,
            'employee_name'   => $employee->name,
            'start_date'      => now()->format('Y-m-d'),
            'end_date'        => now()->addDays(3)->format('Y-m-d'),
            'reason'          => 'Urusan Keluarga',
            'status'          => 'pending',
            'submission_date' => now()->format('Y-m-d'),
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'CREATE',
            'module' => 'Leave & Permit',
        ]);

        $leave->update(['status' => 'approved']);
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'UPDATE',
            'module' => 'Leave & Permit',
        ]);

        $leave->delete();
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'DELETE',
            'module' => 'Leave & Permit',
        ]);
    }

    /** TEST 4: OBSERVER EVALUASI KINERJA (PERFORMANCE EVALUATION) */
    public function test_performance_evaluation_observer_logs_all_actions()
    {
        $employee = $this->createFullEmployee('Helper Employee Eval', 'helper.eval@erphris.com', '081234567893');

        $eval = PerformanceEvaluation::create([
            'employee_id'     => $employee->id,
            'evaluator_id'    => $this->testUser->id,
            'evaluation_date' => now()->format('Y-m-d'),
            'score'           => 85,
            'criteria_scores' => json_encode(['kedisiplinan' => 85, 'kerja_tim' => 85]),
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'CREATE',
            'module' => 'Performance Evaluation',
        ]);

        $eval->update(['score' => 90]);
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'UPDATE',
            'module' => 'Performance Evaluation',
        ]);

        $eval->delete();
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'DELETE',
            'module' => 'Performance Evaluation',
        ]);
    }
}