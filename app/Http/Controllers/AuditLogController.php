<?php
namespace App\Http\Controllers;

use App\Services\AuditLogService;

class AuditLogController extends Controller
{
    protected $auditService;

    public function __construct(AuditLogService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function indexTemp()
    {
        $logs = $this->auditService->getAllLogs();
        return view('employee.audit', compact('logs'));
    }
}