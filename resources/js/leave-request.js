document.addEventListener('DOMContentLoaded', function () {
    const employeeInput = document.getElementById('employee_id');
    const employeeNameInput = document.getElementById('employee_name');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const remainingLeaveDisplay = document.getElementById('remaining_leave_display');
    const totalDaysDisplay = document.getElementById('total_days_display');
    const submitBtn = document.querySelector('button[type="submit"]');

    let currentRemainingLeave = 0;

    if (employeeInput) {
        employeeInput.addEventListener('change', function () {
            const code = this.value.trim();
            if (code.length >= 4) {
                fetch(`/employees/${code}/leave-balance`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.found) {
                            currentRemainingLeave = data.remaining_leave;
                            if (employeeNameInput) {
                                employeeNameInput.value = data.employee_name;
                            }
                            if (remainingLeaveDisplay) {
                                remainingLeaveDisplay.textContent = `Sisa Cuti: ${data.remaining_leave} hari`;
                                remainingLeaveDisplay.className = data.remaining_leave > 0
                                    ? 'text-sm font-semibold text-emerald-600'
                                    : 'text-sm font-semibold text-red-600';
                            }
                            updateTotalDays();
                        } else {
                            if (employeeNameInput) employeeNameInput.value = '';
                            if (remainingLeaveDisplay) {
                                remainingLeaveDisplay.textContent = 'Karyawan tidak ditemukan';
                                remainingLeaveDisplay.className = 'text-sm font-semibold text-red-600';
                            }
                        }
                    });
            }
        });
    }

    if (startDateInput) {
        startDateInput.addEventListener('change', updateTotalDays);
    }
    if (endDateInput) {
        endDateInput.addEventListener('change', updateTotalDays);
    }

    function updateTotalDays() {
        if (!totalDaysDisplay) return;

        const start = startDateInput ? startDateInput.value : null;
        const end = endDateInput ? endDateInput.value : null;

        if (start && end && end >= start) {
            const startDate = new Date(start);
            const endDate = new Date(end);
            const diffTime = Math.abs(endDate - startDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

            totalDaysDisplay.textContent = `Total Hari: ${diffDays} hari`;
            totalDaysDisplay.className = 'text-sm font-semibold text-indigo-600';

            if (currentRemainingLeave > 0 && diffDays > currentRemainingLeave) {
                totalDaysDisplay.textContent += ' — Melebihi sisa cuti!';
                totalDaysDisplay.className = 'text-sm font-semibold text-red-600';
                if (submitBtn) submitBtn.disabled = true;
            } else {
                if (submitBtn) submitBtn.disabled = false;
            }
        } else if (start && end && end < start) {
            totalDaysDisplay.textContent = 'Tanggal selesai harus setelah tanggal mulai';
            totalDaysDisplay.className = 'text-sm font-semibold text-red-600';
        } else {
            totalDaysDisplay.textContent = '';
        }
    }
});
