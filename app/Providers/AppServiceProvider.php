<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// IMPORT MODEL
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\PerformanceEvaluation;
use App\Models\Jobrole;

// IMPORT OBSERVER
use App\Observers\EmployeeObserver;
use App\Observers\AttendanceObserver;
use App\Observers\LeaveRequestObserver;
use App\Observers\PerformanceEvaluationObserver;
use App\Observers\JobRoleObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Employee::observe(EmployeeObserver::class);
        Attendance::observe(AttendanceObserver::class);
        LeaveRequest::observe(LeaveRequestObserver::class);
        PerformanceEvaluation::observe(PerformanceEvaluationObserver::class);
        Jobrole::observe(JobRoleObserver::class);
    }
}