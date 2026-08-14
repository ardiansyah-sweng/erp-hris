<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('payrolls', 'position_allowance')) {
            Schema::table('payrolls', function (Blueprint $table) {
                // Komponen tunjangan detail
                $table->decimal('position_allowance', 15, 2)->default(0)->after('allowances');
                $table->decimal('meal_allowance', 15, 2)->default(0)->after('position_allowance');
                $table->decimal('transport_allowance', 15, 2)->default(0)->after('meal_allowance');

                // Komponen lembur (dari Overtime module)
                $table->decimal('overtime_hours', 4, 1)->default(0)->after('transport_allowance');
                $table->decimal('overtime_pay', 15, 2)->default(0)->after('overtime_hours');

                // Komponen reimbursement (dari Reimbursement module)
                $table->decimal('reimbursement_total', 15, 2)->default(0)->after('overtime_pay');

                // Komponen potongan detail
                $table->decimal('pph21', 15, 2)->default(0)->after('deductions');
                $table->decimal('bpjs_kesehatan', 15, 2)->default(0)->after('pph21');
                $table->decimal('bpjs_ketenagakerjaan', 15, 2)->default(0)->after('bpjs_kesehatan');

                // Tanggal pembayaran (jika belum ada)
                if (!Schema::hasColumn('payrolls', 'payment_date')) {
                    $table->date('payment_date')->nullable()->after('status');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropColumn([
                'position_allowance',
                'meal_allowance',
                'transport_allowance',
                'overtime_hours',
                'overtime_pay',
                'reimbursement_total',
                'pph21',
                'bpjs_kesehatan',
                'bpjs_ketenagakerjaan',
            ]);
        });
    }
};
