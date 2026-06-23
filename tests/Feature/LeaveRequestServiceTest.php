<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\LeaveRequest;
use App\Services\LeaveRequestService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeaveRequestServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_leave_requests()
    {
        LeaveRequest::create([
            'employee_id' => 'EMP001',
            'employee_name' => 'Budi Santoso',
            'start_date' => now(),
            'end_date' => now(),
            'reason' => 'Cuti Tahunan',
            'status' => 'Pending',
            'submission_date' => now(),
        ]);

        $service = new LeaveRequestService();

        $result = $service->getAllLeaveRequests();

        $this->assertCount(1, $result);
    }

    public function test_get_leave_request_detail()
    {
        $leaveRequest = LeaveRequest::create([
            'employee_id' => 'EMP002',
            'employee_name' => 'Siti Aminah',
            'start_date' => now(),
            'end_date' => now(),
            'reason' => 'Acara Keluarga',
            'status' => 'Approved',
            'submission_date' => now(),
        ]);

        $service = new LeaveRequestService();

        $result = $service->getLeaveRequestDetail($leaveRequest->id);

        $this->assertNotNull($result);
        $this->assertEquals('EMP002', $result->employee_id);
    }
}