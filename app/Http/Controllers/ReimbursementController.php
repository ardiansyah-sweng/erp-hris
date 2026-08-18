<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Reimbursement;
use App\Services\ReimbursementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReimbursementController extends Controller
{
    protected $reimbursementService;

    public function __construct(ReimbursementService $reimbursementService)
    {
        $this->reimbursementService = $reimbursementService;
    }

    public function index(Request $request)
    {
        $filters = [
            'status'      => $request->query('status'),
            'category'    => $request->query('category'),
            'employee_id' => $request->query('employee_id'),
        ];

        $reimbursements = $this->reimbursementService->getAllReimbursements($filters);
        $employees = Employee::orderBy('name')->get();

        return view('reimbursement.index', compact('reimbursements', 'employees', 'filters'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->orderBy('name')->get();
        $categories = Reimbursement::CATEGORIES;

        return view('reimbursement.create', compact('employees', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id'     => 'required|exists:employees,id',
            'category'        => 'required|in:transport,medical,meal,training,other',
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'amount'          => 'required|numeric|min:1',
            'submission_date' => 'required|date',
            'receipt'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'public');
            $validated['receipt_path'] = $path;
        }

        $reimbursement = $this->reimbursementService->createReimbursement($validated);

        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'CREATE',
            'module'      => 'Reimbursement',
            'description' => 'Pengajuan klaim baru: ' . $reimbursement->title . ' (Rp ' . number_format($reimbursement->amount, 0, ',', '.') . ')',
            'created_at'  => now()
        ]);

        return redirect()->route('reimbursement.index')->with('success', 'Pengajuan reimbursement berhasil dikirim.');
    }

    public function show($id)
    {
        $reimbursement = $this->reimbursementService->getReimbursementDetail($id);

        if (!$reimbursement) {
            abort(404, 'Data reimbursement tidak ditemukan');
        }

        return view('reimbursement.show', compact('reimbursement'));
    }

    public function approve($id)
    {
        $userId = auth()->id() ?? 1;
        $reimbursement = $this->reimbursementService->approveReimbursement($id, $userId);

        if (!$reimbursement) {
            return redirect()->back()->with('error', 'Gagal menyetujui klaim reimbursement.');
        }

        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'APPROVE',
            'module'      => 'Reimbursement',
            'description' => 'Menyetujui klaim ID: ' . $id . ' (Rp ' . number_format($reimbursement->amount, 0, ',', '.') . ')',
            'created_at'  => now()
        ]);

        return redirect()->back()->with('success', 'Klaim reimbursement berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $userId = auth()->id() ?? 1;
        $reason = $request->input('rejection_reason');

        $reimbursement = $this->reimbursementService->rejectReimbursement($id, $userId, $reason);

        if (!$reimbursement) {
            return redirect()->back()->with('error', 'Gagal menolak klaim reimbursement.');
        }

        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'REJECT',
            'module'      => 'Reimbursement',
            'description' => 'Menolak klaim ID: ' . $id,
            'created_at'  => now()
        ]);

        return redirect()->back()->with('success', 'Klaim reimbursement ditolak.');
    }

    public function destroy($id)
    {
        $deleted = $this->reimbursementService->deleteReimbursement($id);

        if (!$deleted) {
            return redirect()->back()->with('error', 'Data tidak dapat dihapus (mungkin sudah disetujui/ditolak).');
        }

        return redirect()->route('reimbursement.index')->with('success', 'Data reimbursement berhasil dihapus.');
    }
}
