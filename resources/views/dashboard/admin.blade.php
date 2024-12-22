@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <!-- Card yang sudah ada -->
    <div class="col-md-3">
        <div class="card stat-card bg-white" onclick="filterLaporan('semua')">
            <div class="card-body text-center">
                <div class="card-title">Total Laporan</div>
                <div class="card-number text-primary" id="total-laporan">{{ $totalLaporan }}</div>
                <div class="text-muted"><i class="bi bi-file-text me-1"></i> Semua Laporan</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-2">
        <div class="card stat-card bg-white" onclick="filterLaporan('menunggu')">
            <div class="card-body text-center">
                <div class="card-title">Menunggu</div>
                <div class="card-number text-warning" id="total-menunggu">
                    {{ $laporanByStatus['Menunggu'] ?? 0 }}
                </div>
                <div class="text-muted"><i class="bi bi-clock me-1"></i> Belum Diproses</div>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card stat-card bg-white" onclick="filterLaporan('proses')">
            <div class="card-body text-center">
                <div class="card-title">Proses</div>
                <div class="card-number text-info" id="total-proses">
                    {{ $laporanByStatus['Proses'] ?? 0 }}
                </div>
                <div class="text-muted"><i class="bi bi-gear me-1"></i> Sedang Ditangani</div>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card stat-card bg-white" onclick="filterLaporan('selesai')">
            <div class="card-body text-center">
                <div class="card-title">Selesai</div>
                <div class="card-number text-success" id="total-selesai">
                    {{ $laporanByStatus['Selesai'] ?? 0 }}
                </div>
                <div class="text-muted"><i class="bi bi-check-circle me-1"></i> Telah Diselesaikan</div>
            </div>
        </div>
    </div>

    <!-- Tambahkan card Ditolak -->
    <div class="col-md-2">
        <div class="card stat-card bg-white" onclick="filterLaporan('ditolak')">
            <div class="card-body text-center">
                <div class="card-title">Ditolak</div>
                <div class="card-number text-danger" id="total-ditolak">
                    {{ $laporanByStatus['Ditolak'] ?? 0 }}
                </div>
                <div class="text-muted"><i class="bi bi-x-circle me-1"></i> Tidak Disetujui</div>
            </div>
        </div>
    </div>
</div>

<div class="card bg-white shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0">
            <i class="bi bi-table me-2"></i>
            Daftar Laporan Masyarakat
        </h5>
    </div>
    <div class="card-body">
        @include('components.laporan-table', ['isAdmin' => true])
    </div>
</div>


@include('components.detail-modal')

@push('scripts')
<script>

function filterLaporan(status) {
    const cards = document.querySelectorAll('.stat-card');
    cards.forEach(card => card.classList.remove('border-primary'));
    event.currentTarget.classList.add('border-primary');

    // AJAX request untuk memfilter laporan
    fetch(`/laporan/filter/${status}`)
        .then(response => response.json())
        .then(data => {
            document.querySelector('#laporan-table tbody').innerHTML = data.html;
        });
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
            document.getElementById('total-ditolak').textContent = data.ditolak;
        });
}, 5000);

</script>
@endpush
@endsection