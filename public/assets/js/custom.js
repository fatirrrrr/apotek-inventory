// Custom JavaScript untuk Sistem Manajemen Inventaris Apotek
// Versi Sederhana - Tanpa Chart.js

// Utility Functions
const Apotek = {
    // Format angka ke rupiah
    formatRupiah: function (angka) {
        return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },

    // Format tanggal Indonesia
    formatTanggal: function (tanggal) {
        const bulan = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "Mei",
            "Jun",
            "Jul",
            "Agu",
            "Sep",
            "Okt",
            "Nov",
            "Des",
        ];
        const date = new Date(tanggal);
        return (
            date.getDate() +
            " " +
            bulan[date.getMonth()] +
            " " +
            date.getFullYear()
        );
    },

    // Show toast notification
    showToast: function (message, type = "success") {
        const toastClass =
            type === "success"
                ? "alert-success"
                : type === "error"
                ? "alert-danger"
                : type === "warning"
                ? "alert-warning"
                : "alert-info";

        const toastHtml = `
            <div class="alert ${toastClass} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        document.body.insertAdjacentHTML("beforeend", toastHtml);

        // Auto remove after 4 seconds
        setTimeout(function () {
            const alert = document.querySelector(".alert.position-fixed");
            if (alert) {
                alert.remove();
            }
        }, 4000);
    },
};

// DOM Ready
document.addEventListener("DOMContentLoaded", function () {
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll(".alert:not(.alert-permanent)");
    alerts.forEach(function (alert) {
        setTimeout(function () {
            alert.style.display = "none";
        }, 5000);
    });

    // Sidebar toggle for mobile
    const sidebarToggle = document.querySelector("[data-sidebar-toggle]");
    const sidebar = document.querySelector(".sidebar");

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener("click", function () {
            sidebar.classList.toggle("show");
        });
    }

    // Form validation
    const forms = document.querySelectorAll(".needs-validation");
    forms.forEach(function (form) {
        form.addEventListener("submit", function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add("was-validated");
        });
    });

    // Table search functionality
    const searchInput = document.querySelector(".table-search");
    const dataTable = document.querySelector(".data-table tbody");

    if (searchInput && dataTable) {
        searchInput.addEventListener("input", function () {
            const searchTerm = this.value.toLowerCase();
            const rows = dataTable.querySelectorAll("tr");

            rows.forEach(function (row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? "" : "none";
            });
        });
    }

    // Number formatting for rupiah inputs
    const rupiahInputs = document.querySelectorAll(".format-rupiah");
    rupiahInputs.forEach(function (input) {
        input.addEventListener("input", function () {
            let value = this.value.replace(/[^\d]/g, "");
            if (value) {
                // Format without Rp prefix for input value
                this.value = parseInt(value).toLocaleString("id-ID");
            }
        });
    });

    // Delete confirmation
    window.confirmDelete = function (
        url,
        message = "Apakah Anda yakin ingin menghapus data ini?"
    ) {
        if (confirm(message)) {
            const form = document.createElement("form");
            form.method = "POST";
            form.action = url;

            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                const csrfInput = document.createElement("input");
                csrfInput.type = "hidden";
                csrfInput.name = "_token";
                csrfInput.value = csrfToken.getAttribute("content");
                form.appendChild(csrfInput);
            }

            // Add DELETE method
            const methodInput = document.createElement("input");
            methodInput.type = "hidden";
            methodInput.name = "_method";
            methodInput.value = "DELETE";
            form.appendChild(methodInput);

            document.body.appendChild(form);
            form.submit();
        }
    };

    // Print functionality
    window.printPage = function () {
        window.print();
    };

    // Export functionality
    window.exportData = function (format, url) {
        window.location.href = url;
    };

    // Stok warning checker
    const stokInputs = document.querySelectorAll(".stok-input");
    stokInputs.forEach(function (input) {
        input.addEventListener("input", function () {
            const stokValue = parseInt(this.value) || 0;
            const parent = this.parentElement;

            // Remove existing warning
            const existingWarning = parent.querySelector(".stok-warning");
            if (existingWarning) {
                existingWarning.remove();
            }

            if (stokValue <= 5) {
                const warning = document.createElement("div");
                warning.className = "stok-warning text-danger small mt-1";
                warning.innerHTML =
                    '<i class="fas fa-exclamation-triangle"></i> Stok rendah!';
                parent.appendChild(warning);
                this.classList.add("border-warning");
            } else {
                this.classList.remove("border-warning");
            }
        });
    });

    // Tanggal expired checker
    const expiredInputs = document.querySelectorAll(".expired-input");
    expiredInputs.forEach(function (input) {
        input.addEventListener("change", function () {
            const expiredDate = new Date(this.value);
            const today = new Date();
            const timeDiff = expiredDate.getTime() - today.getTime();
            const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
            const parent = this.parentElement;

            // Remove existing warning
            const existingWarning = parent.querySelector(".expired-warning");
            if (existingWarning) {
                existingWarning.remove();
            }

            if (daysDiff <= 30 && daysDiff > 0) {
                const warning = document.createElement("div");
                warning.className = "expired-warning text-warning small mt-1";
                warning.innerHTML =
                    '<i class="fas fa-clock"></i> Akan expired dalam ' +
                    daysDiff +
                    " hari!";
                parent.appendChild(warning);
                this.classList.add("border-warning");
            } else if (daysDiff <= 0) {
                const warning = document.createElement("div");
                warning.className = "expired-warning text-danger small mt-1";
                warning.innerHTML =
                    '<i class="fas fa-exclamation-circle"></i> Sudah expired!';
                parent.appendChild(warning);
                this.classList.add("border-danger");
            } else {
                this.classList.remove("border-warning", "border-danger");
            }
        });
    });

    // TRANSAKSI - Obat selection dengan auto-fill harga dan stok info
    const obatSelect = document.querySelector("#obat_id");
    const hargaInput = document.querySelector("#harga");
    const stokInfo = document.querySelector("#stok-info");

    if (obatSelect && hargaInput) {
        obatSelect.addEventListener("change", function () {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const harga = selectedOption.getAttribute("data-harga");
                const stok = selectedOption.getAttribute("data-stok");

                hargaInput.value = harga;

                if (stokInfo) {
                    stokInfo.textContent = `Stok tersedia: ${stok}`;
                    stokInfo.className =
                        parseInt(stok) <= 5
                            ? "text-danger small"
                            : "text-success small";
                }

                // Trigger total calculation
                calculateTotal();
            } else {
                hargaInput.value = "";
                if (stokInfo) {
                    stokInfo.textContent = "";
                }
            }
        });
    }

    // TRANSAKSI - Auto calculate total
    const jumlahInput = document.querySelector("#jumlah");
    const totalInput = document.querySelector("#total");

    function calculateTotal() {
        if (hargaInput && jumlahInput && totalInput) {
            const harga = parseInt(hargaInput.value) || 0;
            const jumlah = parseInt(jumlahInput.value) || 0;
            const total = harga * jumlah;

            totalInput.value = total;

            // Update display total if exists
            const totalDisplay = document.querySelector("#total-display");
            if (totalDisplay) {
                totalDisplay.textContent = Apotek.formatRupiah(total);
            }
        }
    }

    if (jumlahInput) {
        jumlahInput.addEventListener("input", function () {
            calculateTotal();

            // Check stok availability
            if (obatSelect) {
                const selectedOption =
                    obatSelect.options[obatSelect.selectedIndex];
                const stokTersedia =
                    parseInt(selectedOption.getAttribute("data-stok")) || 0;
                const jumlahDiminta = parseInt(this.value) || 0;
                const parent = this.parentElement;

                // Remove existing warning
                const existingWarning = parent.querySelector(".jumlah-warning");
                if (existingWarning) {
                    existingWarning.remove();
                }

                if (jumlahDiminta > stokTersedia) {
                    const warning = document.createElement("div");
                    warning.className = "jumlah-warning text-danger small mt-1";
                    warning.innerHTML =
                        '<i class="fas fa-exclamation-triangle"></i> Jumlah melebihi stok tersedia!';
                    parent.appendChild(warning);
                    this.classList.add("border-danger");
                } else {
                    this.classList.remove("border-danger");
                }
            }
        });
    }

    // Check expired obat in table
    checkExpiredObat();

    // Dashboard auto-refresh (setiap 5 menit)
    if (document.querySelector(".dashboard-stats")) {
        setInterval(refreshDashboardStats, 300000); // 5 minutes
    }
});

// Function to check expired obat in table
function checkExpiredObat() {
    const today = new Date();
    const expiredCells = document.querySelectorAll(".expired-date");

    expiredCells.forEach(function (cell) {
        const expiredDate = new Date(cell.textContent);
        const timeDiff = expiredDate.getTime() - today.getTime();
        const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
        const row = cell.closest("tr");

        if (daysDiff <= 0) {
            row.classList.add("table-danger");
            cell.innerHTML +=
                ' <span class="badge bg-danger ms-1">Expired</span>';
        } else if (daysDiff <= 30) {
            row.classList.add("table-warning");
            cell.innerHTML += ` <span class="badge bg-warning ms-1">${daysDiff} hari lagi</span>`;
        }
    });
}

// Function to refresh dashboard stats
function refreshDashboardStats() {
    fetch("/dashboard/refresh")
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Update stats if elements exist
                const totalObat = document.querySelector("#total-obat");
                const totalKategori = document.querySelector("#total-kategori");
                const transaksiHariIni = document.querySelector(
                    "#transaksi-hari-ini"
                );
                const pendapatanHariIni = document.querySelector(
                    "#pendapatan-hari-ini"
                );

                if (totalObat) totalObat.textContent = data.stats.total_obat;
                if (totalKategori)
                    totalKategori.textContent = data.stats.total_kategori;
                if (transaksiHariIni)
                    transaksiHariIni.textContent =
                        data.stats.transaksi_hari_ini;
                if (pendapatanHariIni)
                    pendapatanHariIni.textContent = Apotek.formatRupiah(
                        data.stats.pendapatan_hari_ini
                    );
            }
        })
        .catch((error) => console.log("Error refreshing dashboard:", error));
}

// Print receipt function
window.printReceipt = function (transaksiId) {
    const printWindow = window.open(
        `/transaksi/${transaksiId}/print`,
        "_blank"
    );
    if (printWindow) {
        printWindow.onload = function () {
            printWindow.print();
        };
    }
};

// Simple page loader
window.addEventListener("load", function () {
    const loader = document.querySelector(".page-loader");
    if (loader) {
        loader.style.display = "none";
    }
});

// Export Apotek object for global use
window.Apotek = Apotek;
