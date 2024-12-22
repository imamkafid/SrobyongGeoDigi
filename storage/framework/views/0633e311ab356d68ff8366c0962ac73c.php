

<?php $__env->startSection('content'); ?>
<!-- Header Section -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">
        <i class="bi bi-house-fill me-2"></i>
        Dashboard Warga
    </h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#laporanModal">
        <i class="bi bi-plus-circle me-2"></i>
        Buat Laporan Baru
    </button>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <!-- Card yang sudah ada -->
    <div class="col-md-3">
        <div class="card stat-card bg-white" onclick="filterLaporan('semua')">
            <div class="card-body text-center">
                <div class="card-title">Total Laporan</div>
                <div class="card-number text-primary" id="total-laporan"><?php echo e($totalLaporan); ?></div>
                <div class="text-muted"><i class="bi bi-file-text me-1"></i> Semua Laporan</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-2">
        <div class="card stat-card bg-white" onclick="filterLaporan('menunggu')">
            <div class="card-body text-center">
                <div class="card-title">Menunggu</div>
                <div class="card-number text-warning" id="total-menunggu">
                    <?php echo e($laporanByStatus['Menunggu'] ?? 0); ?>

                </div>
                <div class="text-muted"><i class="bi bi-clock-history me-1"></i> Belum Diproses</div>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card stat-card bg-white" onclick="filterLaporan('proses')">
            <div class="card-body text-center">
                <div class="card-title">Proses</div>
                <div class="card-number text-info" id="total-proses">
                    <?php echo e($laporanByStatus['Proses'] ?? 0); ?>

                </div>
                <div class="text-muted"><i class="bi bi-gear-fill me-1"></i> Sedang Ditangani</div>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card stat-card bg-white" onclick="filterLaporan('selesai')">
            <div class="card-body text-center">
                <div class="card-title">Selesai</div>
                <div class="card-number text-success" id="total-selesai">
                    <?php echo e($laporanByStatus['Selesai'] ?? 0); ?>

                </div>
                <div class="text-muted"><i class="bi bi-check-circle-fill me-1"></i> Telah Diselesaikan</div>
            </div>
        </div>
    </div>

    <!-- Tambahkan card Ditolak -->
    <div class="col-md-2">
        <div class="card stat-card bg-white" onclick="filterLaporan('ditolak')">
            <div class="card-body text-center">
                <div class="card-title">Ditolak</div>
                <div class="card-number text-danger" id="total-ditolak">
                    <?php echo e($laporanByStatus['Ditolak'] ?? 0); ?>

                </div>
                <div class="text-muted"><i class="bi bi-x-circle-fill me-1"></i> Tidak Disetujui</div>
            </div>
        </div>
    </div>
</div>

<!-- Laporan Table Card -->
<div class="card bg-white shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0">
            <i class="bi bi-list-ul me-2"></i>
            Daftar Laporan
        </h5>
    </div>
    <div class="card-body">
        <?php echo $__env->make('components.laporan-table', ['isAdmin' => false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>

<!-- Modal Buat Laporan -->
<div class="modal fade" id="laporanModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>
                    Buat Laporan Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="laporanForm" method="POST" action="<?php echo e(route('laporan.store')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-person-badge me-1"></i>
                            NIK Pelapor
                        </label>
                        <input type="text" class="form-control bg-light" value="<?php echo e(session('nik')); ?>" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-card-text me-1"></i>
                            Deskripsi Laporan
                        </label>
                        <textarea class="form-control" name="deskripsi" rows="4" required 
                                placeholder="Jelaskan detail permasalahan..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-camera me-1"></i>
                            Media (Foto/Video)
                        </label>
                        <input type="file" class="form-control" name="media" accept="image/*,video/*">
                        <small class="text-muted">Format yang didukung: JPG, PNG, MP4, maksimal 10MB</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-geo-alt me-1"></i>
                            Lokasi
                        </label>
                        <div id="map" style="height: 300px; border-radius: 8px;"></div>
                        <small class="text-muted mt-2 d-block">
                            <i class="bi bi-info-circle me-1"></i>
                            Klik pada peta untuk menandai lokasi
                        </small>
                        <input type="hidden" name="latitude" id="latitude" required>
                        <input type="hidden" name="longitude" id="longitude" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i>
                            Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php $__env->startPush('styles'); ?>
<style>
    #map { 
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        transition: box-shadow 0.3s ease;
    }
    #map:hover {
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }
    
    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
    }
    
    .modal-content {
        border: none;
        border-radius: 15px;
    }
    
    .modal-header {
        border-bottom: 1px solid rgba(0,0,0,.1);
    }
    
    .form-label {
        font-weight: 500;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
    }

    .bg-primary.rounded-circle {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 24px !important;
        height: 24px !important;
        border-radius: 50%;
        background-color: #0d6efd !important;
    }

    .bg-primary.rounded-circle i {
        font-size: 12px;
        color: white;
        margin-top: 6px;
    }

    .leaflet-popup-content-wrapper {
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .leaflet-popup-content {
        margin: 8px 12px;
        font-weight: 500;
    }

</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Inisialisasi peta
// Koordinat pusat Desa Srobyong yang benar
const SROBYONG_CENTER = [-6.5216, 110.7148];

// Inisialisasi peta saat modal dibuka
document.getElementById('laporanModal').addEventListener('shown.bs.modal', function () {
    // Inisialisasi peta dengan fokus ke Desa Srobyong
    const map = L.map('map', {
        center: SROBYONG_CENTER,
        zoom: 15, // Zoom level yang cukup detail untuk melihat desa
    });

    // Tambahkan layer peta
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Tambahkan marker untuk Kantor Desa
    L.marker(SROBYONG_CENTER, {
        icon: L.divIcon({
            className: 'bg-primary rounded-circle',
            html: '<i class="bi bi-house-fill text-white"></i>',
            iconSize: [24, 24]
        })
    })
    .addTo(map)
    .bindPopup('Kantor Desa Srobyong');

    // Handler untuk klik pada peta
    let marker;
    map.on('click', function(e) {
        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker(e.latlng).addTo(map);
        document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
        document.getElementById('longitude').value = e.latlng.lng.toFixed(6);
    });
});

// Form submission dengan AJAX dan loading state
document.getElementById('laporanForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    try {
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Mengirim...';
        submitBtn.disabled = true;
        
        const formData = new FormData(this);
        const response = await fetch(this.action, {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Tampilkan toast sukses
            const toast = new bootstrap.Toast(document.createElement('div'));
            toast.show();
            
            // Reload halaman setelah delay singkat
            setTimeout(() => location.reload(), 1000);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim laporan');
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
});

// Filter laporan
function filterLaporan(status) {
    const cards = document.querySelectorAll('.stat-card');
    cards.forEach(card => card.classList.remove('border-primary'));
    event.currentTarget.classList.add('border-primary');

    fetch(`/laporan/filter/${status}`)
        .then(response => response.json())
        .then(data => {
            document.querySelector('#laporan-table tbody').innerHTML = data.html;
        })
        .catch(error => console.error('Error:', error));
}

// Real-time updates
setInterval(() => {
    fetch('/laporan/counts')
        .then(response => response.json())
        .then(data => {
            document.getElementById('total-laporan').textContent = data.total;
            document.getElementById('total-menunggu').textContent = data.menunggu;
            document.getElementById('total-proses').textContent = data.proses;
            document.getElementById('total-selesai').textContent = data.selesai;
        })
        .catch(error => console.error('Error:', error));
}, 5000);

// Inisialisasi tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});
</script>
<?php $__env->stopPush(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\srobyong\SrobyongGeoDigi\resources\views/dashboard/warga.blade.php ENDPATH**/ ?>