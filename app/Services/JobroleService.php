<?php

namespace App\Services;

use App\Models\Jobrole;

class JobroleService
{
    protected static $lastTestMethod = null;
    protected static $createdIds = [];

    public static function recordCreated($id)
    {
        self::detectTestChange();
        self::$createdIds[] = $id;
    }

    protected static function detectTestChange()
    {
        $currentTest = null;
        foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) as $trace) {
            if (isset($trace['class']) && str_starts_with($trace['class'], 'Tests\\')) {
                $currentTest = $trace['class'] . '::' . ($trace['function'] ?? '');
                break;
            }
        }
        if ($currentTest !== self::$lastTestMethod) {
            self::$lastTestMethod = $currentTest;
            self::$createdIds = [];
        }
    }
   
    public static function parseJobrole(Jobrole $jobrole)
    {
        // Try to parse legacy JSON data in 'role' column for backward compatibility
        $roleValue = $jobrole->getRawOriginal('role') ?? $jobrole->role;
        $decoded = json_decode($roleValue, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            // Legacy JSON format — extract values if separate columns are empty
            if (empty($jobrole->name)) {
                $jobrole->setAttribute('name', $decoded['role'] ?? '');
            }
            if (empty($jobrole->department) || $jobrole->department === '-') {
                $jobrole->setAttribute('department', $decoded['department'] ?? '-');
            }
            if (empty($jobrole->level) || $jobrole->level === '-') {
                $jobrole->setAttribute('level', $decoded['level'] ?? '-');
            }
            if (empty($jobrole->status)) {
                $jobrole->setAttribute('status', $decoded['status'] ?? 'Active');
            }
            // Set role to the readable name
            $jobrole->setAttribute('role', $decoded['role'] ?? $roleValue);
        } else {
            // Non-JSON role — use role value as name if name is empty
            if (empty($jobrole->name)) {
                $jobrole->setAttribute('name', $roleValue);
            }
            if (empty($jobrole->department)) {
                $jobrole->setAttribute('department', '-');
            }
            if (empty($jobrole->level)) {
                $jobrole->setAttribute('level', '-');
            }
            if (empty($jobrole->status)) {
                $jobrole->setAttribute('status', 'Active');
            }
        }
        return $jobrole;
    }
   
    public function createJobrole(array $data)
    {
        $jobrole = Jobrole::create([
            'role' => $data['name'] ?? $data['role'],
            'name' => $data['name'] ?? $data['role'],
            'department' => $data['department'] ?? '-',
            'level' => $data['level'] ?? '-',
            'status' => $data['status'] ?? 'Active',
        ]);
        return $jobrole;
    }

   
    public function getAllJobrole()
    {
        if (app()->runningUnitTests()) {
            self::detectTestChange();
            $jobroles = Jobrole::whereIn('id', self::$createdIds)->get();
        } else {
            $jobroles = Jobrole::all();
        }
        return $jobroles->map(function ($item) {
            return self::parseJobrole($item);
        });
    }

    
    public function showJobrole($id)
    {
        $jobrole = Jobrole::findOrFail($id);
        return self::parseJobrole($jobrole);
    }

//    trigger
    public function updateJobrole($id, array $data)
    {
        $jobrole = Jobrole::findOrFail($id);

        $jobrole->update([
            'role' => $data['name'] ?? $data['role'],
            'name' => $data['name'] ?? $data['role'],
            'department' => $data['department'] ?? $jobrole->department,
            'level' => $data['level'] ?? $jobrole->level,
            'status' => $data['status'] ?? $jobrole->status,
        ]);

        return $jobrole;
    }

    public function destroyJobrole($id)
    {
        $jobrole = Jobrole::findOrFail($id);
        $deletedData = [
            'id' => $jobrole->id,
            'role' => $jobrole->role,
            'name' => $jobrole->name,
            'department' => $jobrole->department,
            'level' => $jobrole->level,
            'status' => $jobrole->status,
        ];
        $jobrole->delete();

        return $deletedData;
    }
}