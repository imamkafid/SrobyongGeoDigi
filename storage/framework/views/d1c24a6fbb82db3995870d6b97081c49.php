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
                        <label class="form-label">NIK Pelapor</label>
                        <input type="text" class="form-control bg-light" value="<?php echo e(session('nik')); ?>" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Laporan</label>
                        <textarea class="form-control" name="deskripsi" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Media (Foto/Video)</label>
                        <input type="file" class="form-control" name="media" accept="image/*,video/*">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <div id="form-map" style="height: 400px;"></div>
                        <input type="hidden" name="latitude" id="latitude" required>
                        <input type="hidden" name="longitude" id="longitude" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Kirim Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
const SROBYONG_CENTER = [-6.5216, 110.7148];
let formMap = null;

document.getElementById('laporanModal').addEventListener('shown.bs.modal', function () {
    setTimeout(() => {
        if (formMap) {
            formMap.remove();
        }

        formMap = L.map('form-map').setView(SROBYONG_CENTER, 15);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(formMap);

        let marker = L.marker(SROBYONG_CENTER).addTo(formMap);

        formMap.on('click', function(e) {
            marker.setLatLng(e.latlng);
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });

        formMap.invalidateSize();
    }, 300);
});

document.getElementById('laporanModal').addEventListener('hidden.bs.modal', function () {
    if (formMap) {
        formMap.remove();
        formMap = null;
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
#form-map {
    height: 400px !important;
    width: 100% !important;
    z-index: 1001 !important;
}

.leaflet-container {
    z-index: 1001 !important;
}
</style>
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\srobyong\SrobyongGeoDigi\resources\views/components/form-laporan-modal.blade.php ENDPATH**/ ?>