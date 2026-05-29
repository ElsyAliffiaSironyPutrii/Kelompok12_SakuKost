document.addEventListener("DOMContentLoaded", function() {
    const btnAcc = document.querySelectorAll('.btn-acc');
    btnAcc.forEach(function(button) {
        button.addEventListener('click', function(e) {
            if (!confirm('Setujui pembayaran ini?')) {
                e.preventDefault();
            }
        });
    });

    const btnDeny = document.querySelectorAll('.btn-deny');
    btnDeny.forEach(function(button) {
        button.addEventListener('click', function(e) {
            if (!confirm('Tolak pembayaran ini?')) {
                e.preventDefault();
            }
        });
    });

    const btnDeleteReport = document.querySelectorAll('.btn-delete-report');
    btnDeleteReport.forEach(function(button) {
        button.addEventListener('click', function(e) {
            if (!confirm('Selesaikan & hapus laporan ini?')) {
                e.preventDefault();
            }
        });
    });
});