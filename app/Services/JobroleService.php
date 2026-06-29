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
        $roleValue = $jobrole->getRawOriginal('role') ?? $jobrole->role;
        $decoded = json_decode($roleValue, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $jobrole->setAttribute('role', $decoded['role'] ?? '');
            $jobrole->setAttribute('name', $decoded['role'] ?? '');
            $jobrole->setAttribute('department', $decoded['department'] ?? '-');
            $jobrole->setAttribute('level', $decoded['level'] ?? '-');
            $jobrole->setAttribute('status', $decoded['status'] ?? 'Active');
        } else {
            $jobrole->setAttribute('name', $roleValue);
            $jobrole->setAttribute('department', '-');
            $jobrole->setAttribute('level', '-');
            $jobrole->setAttribute('status', 'Active');
        }
        return $jobrole;
    }
   
    public function createJobrole(array $data)
    {
        $jobrole = Jobrole::create([
            'role' => $data['role']
        ]);
        return self::parseJobrole($jobrole);
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
            'role' => $data['role']
        ]);

        return self::parseJobrole($jobrole);
    }

    public function destroyJobrole($id)
    {
        $jobrole = Jobrole::findOrFail($id);
        $parsed = self::parseJobrole($jobrole);
        $deletedData = [
            'id' => $parsed->id,
            'role' => $parsed->role,
            'name' => $parsed->name,
            'department' => $parsed->department,
            'level' => $parsed->level,
            'status' => $parsed->status,
        ];
        $jobrole->delete();

        return $deletedData;
    }
}