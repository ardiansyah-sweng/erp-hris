<?php

namespace App\Services;

use App\Models\Reimbursement;
use App\Models\Employee;

class ReimbursementService
{
    /**
     * Ambil semua data reimbursement.
     */
    public function getAllReimbursements($filters = [])
    {
        $query = Reimbursement::with(['employee.jobrole', 'approver']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (!empty($filters['employee_id'])) {
            $query->where('employee_id', $filters['employee_id']);
        }

        return $query->orderByDesc('submission_date')->get();
    }

    /**
     * Buat klaim reimbursement baru.
     */
    public function createReimbursement(array $data): Reimbursement
    {
        return Reimbursement::create([
            'employee_id'     => $data['employee_id'],
            'category'        => $data['category'],
            'title'           => $data['title'],
            'description'     => $data['description'] ?? null,
            'amount'          => $data['amount'],
            'receipt_path'    => $data['receipt_path'] ?? null,
            'submission_date' => $data['submission_date'] ?? now()->toDateString(),
            'status'          => 'pending',
        ]);
    }

    /**
     * Approve klaim reimbursement.
     */
    public function approveReimbursement($id, $approvedBy): ?Reimbursement
    {
        $reimbursement = Reimbursement::find($id);

        if (!$reimbursement || $reimbursement->status !== 'pending') {
            return null;
        }

        $reimbursement->update([
            'status'      => 'approved',
            'approved_by' => $approvedBy,
            'approved_at' => now(),
        ]);

        return $reimbursement;
    }

    /**
     * Reject klaim reimbursement.
     */
    public function rejectReimbursement($id, $approvedBy, $reason = null): ?Reimbursement
    {
        $reimbursement = Reimbursement::find($id);

        if (!$reimbursement || $reimbursement->status !== 'pending') {
            return null;
        }

        $reimbursement->update([
            'status'           => 'rejected',
            'approved_by'      => $approvedBy,
            'rejection_reason' => $reason,
        ]);

        return $reimbursement;
    }

    /**
     * Total klaim approved karyawan per bulan (untuk integrasi Payroll).
     */
    public function getEmployeeReimbursementTotal($employeeId, $month, $year): float
    {
        return Reimbursement::where('employee_id', $employeeId)
            ->approved()
            ->whereMonth('submission_date', $month)
            ->whereYear('submission_date', $year)
            ->sum('amount');
    }

    /**
     * Hapus klaim (hanya jika masih pending).
     */
    public function deleteReimbursement($id): bool
    {
        $reimbursement = Reimbursement::find($id);

        if (!$reimbursement || $reimbursement->status !== 'pending') {
            return false;
        }

        return $reimbursement->delete();
    }

    /**
     * Detail reimbursement.
     */
    public function getReimbursementDetail($id): ?Reimbursement
    {
        return Reimbursement::with(['employee.jobrole', 'approver'])->find($id);
    }
}
