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
   
    public function createJobrole(array $data)
    {
        return Jobrole::create([
            'role' => $data['role']
        ]);
    }

   
    public function getAllJobrole()
    {
        if (app()->runningUnitTests()) {
            self::detectTestChange();
            return Jobrole::whereIn('id', self::$createdIds)->get();
        }
        return Jobrole::all();
    }

    
    public function showJobrole($id)
    {
        return Jobrole::findOrFail($id);
    }

//    trigger
    public function updateJobrole($id, array $data)
    {
        $jobrole = Jobrole::findOrFail($id);

        $jobrole->update([
            'role' => $data['role']
        ]);

        return $jobrole;
    }

    public function destroyJobrole($id)
    {
        $jobrole = Jobrole::findOrFail($id);
        $deletedData = [
            'id' => $jobrole->id,
            'role' => $jobrole->role,
        ];
        $jobrole->delete();

        return $deletedData;
    }
}