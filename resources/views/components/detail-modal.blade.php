<div class="modal fade" id="detailModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle me-2"></i>
                    Detail Laporan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">NIK Pelapor</label>
                            <p class="detail-nik"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Deskripsi</label>
                            <p class="detail-deskripsi"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Status</label>
                            <p class="detail-status"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Tanggal Laporan</label>
                            <p class="detail-tanggal"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Lokasi</label>
                            <div id="detail-map" style="height: 300px; border-radius: 8px;"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Media</label>
                            <div class="detail-media"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const SROBYONG_CENTER = [-6.5216, 110.7148];
let detailMap;


// Inisialisasi peta saat modal dibuka
document.getElementById('detailModal').addEventListener('shown.bs.modal', function () {
    if (!detailMap) {
        detailMap = L.map('detail-map', {
            center: SROBYONG_CENTER,
            zoom: 15
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(detailMap);

        // Marker pusat desa
        L.marker(SROBYONG_CENTER, {
            icon: L.divIcon({
                className: 'bg-primary rounded-circle',
                html: '<i class="bi bi-house-fill text-white"></i>',
                iconSize: [24, 24]
            })
        })
        .addTo(detailMap)
        .bindPopup('Kantor Desa Srobyong');
    }

    // Update ukuran peta setelah modal dibuka
    setTimeout(() => {
        detailMap.invalidateSize();
    }, 100);
});

function showDetail(id) {
    fetch(`/laporan/${id}`)
        .then(response => response.json())
        .then(data => {
            document.querySelector('.detail-nik').textContent = data.nik_pelapor;
            document.querySelector('.detail-deskripsi').textContent = data.deskripsi;
            document.querySelector('.detail-status').textContent = data.status;
            document.querySelector('.detail-tanggal').textContent = new Date(data.created_at).toLocaleString('id-ID');

            // Update lokasi di peta
            if (detailMap) {
                // Hapus marker lama jika ada
                detailMap.eachLayer((layer) => {
                    if (layer instanceof L.Marker && !layer._icon.classList.contains('bg-primary')) {
                        detailMap.removeLayer(layer);
                    }
                });

                // Tambah marker baru
                const latlng = [parseFloat(data.latitude), parseFloat(data.longitude)];
                L.marker(latlng).addTo(detailMap);
                detailMap.setView(latlng, 16);
            }

            // Tampilkan media jika ada
            const mediaContainer = document.querySelector('.detail-media');
            if (data.media_path) {
                // Pastikan path media benar
                const mediaUrl = data.media_path.startsWith('/storage') 
                    ? data.media_path 
                    : `/storage/${data.media_path}`;
                    
                const fileExt = data.media_path.split('.').pop().toLowerCase();
                
                if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExt)) {
                    mediaContainer.innerHTML = `
                        <div class="position-relative">
                            <img src="${mediaUrl}" class="img-fluid rounded" alt="Lampiran">
                            <a href="${mediaUrl}" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 m-2" 
                               target="_blank" title="Lihat ukuran penuh">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </a>
                        </div>`;
                } else if (['mp4', 'webm', 'mov'].includes(fileExt)) {
                    mediaContainer.innerHTML = `
                        <div class="position-relative">
                            <video controls class="w-100 rounded">
                                <source src="${mediaUrl}" type="video/${fileExt}">
                                Browser Anda tidak mendukung pemutaran video.
                            </video>
                            <a href="${mediaUrl}" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 m-2" 
                               target="_blank" title="Unduh video">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>`;
                }
            } else {
                mediaContainer.innerHTML = `
                    <div class="alert alert-light text-center">
                        <i class="bi bi-image text-muted"></i>
                        <p class="mb-0">Tidak ada media yang dilampirkan</p>
                    </div>`;
            }

            new bootstrap.Modal(document.getElementById('detailModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat detail laporan');
        });
}
</script>
@endpush

@push('styles')
<style>
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

#detail-map {
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    transition: box-shadow 0.3s ease;
}

#detail-map:hover {
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
}

.detail-media img, 
.detail-media video {
    max-height: 300px;
    object-fit: contain;
    width: 100%;
    background: #f8f9fa;
}

.detail-media .position-relative {
    display: inline-block;
    width: 100%;
}

.detail-media .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    opacity: 0.9;
}

.detail-media .btn-sm:hover {
    opacity: 1;
}

.alert {
    margin-bottom: 0;
}
</style>
@endpush