<div class="table-responsive">
    <table class="table table-hover align-middle" id="laporan-table">
        <thead>
            <tr class="text-center">
                <th style="width: 80px">ID</th>
                <th style="width: 180px">Tanggal</th>
                <th style="width: 150px">NIK Pelapor</th>
                <th style="width: 150px">Status</th>
                <th style="width: 100px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $item)
            <tr class="text-center">
                <td>#{{ $item->id }}</td>
                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $item->nik_pelapor }}</td>
                <td>
                    @if($isAdmin)
                        <select class="form-select form-select-sm status-select mx-auto" 
                                style="width: 130px;"
                                data-id="{{ $item->id }}"
                                data-original="{{ $item->status }}">
                            @foreach(['Menunggu', 'Proses', 'Selesai', 'Ditolak'] as $status)
                                <option value="{{ $status }}" 
                                        {{ $item->status == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <span class="badge status-{{ strtolower($item->status) }}">
                            {{ $item->status }}
                        </span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-sm btn-info" 
                            onclick="showDetail({{ $item->id }})"
                            title="Lihat Detail">
                        <i class="bi bi-eye-fill"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@push('styles')
<style>
/* Style untuk status badges */
.badge {
    padding: 0.5em 1em;
    font-weight: 500;
    font-size: 0.875rem;
}

.status-menunggu {
    background-color: #fff3cd;
    color: #856404;
}

.status-proses {
    background-color: #cff4fc;
    color: #055160;
}

.status-selesai {
    background-color: #d1e7dd;
    color: #0f5132;
}

.status-ditolak {
    background-color: #f8d7da;
    color: #842029;
}

/* Style untuk select status */
.status-select {
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    cursor: pointer;
    background-color: white;
}

.status-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

/* Style untuk tabel */
.table {
    margin-bottom: 0;
}

.table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    padding: 0.75rem;
}

.table td {
    padding: 0.75rem;
    vertical-align: middle;
}

/* Style untuk tombol aksi */
.btn-info {
    background-color: #0dcaf0;
    border-color: #0dcaf0;
    color: white;
}

.btn-info:hover {
    background-color: #31d2f2;
    border-color: #25cff2;
    color: white;
}
</style>
@endpush

@push('scripts')
<script>
document.querySelectorAll('.status-select').forEach(select => {
    select.addEventListener('change', function() {
        const id = this.dataset.id;
        const status = this.value;
        const originalStatus = this.dataset.original;
        const select = this;

        // Disable select sementara
        select.disabled = true;

        // Kirim request update status
        fetch(`/laporan/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update data-original
                select.dataset.original = status;
                
                // Update counts
                fetch('/laporan/counts')
                    .then(response => response.json())
                    .then(counts => {
                        document.getElementById('total-laporan').textContent = counts.total;
                        document.getElementById('total-menunggu').textContent = counts.menunggu;
                        document.getElementById('total-proses').textContent = counts.proses;
                        document.getElementById('total-selesai').textContent = counts.selesai;
                        document.getElementById('total-ditolak').textContent = counts.ditolak;
                    });

                // Tampilkan notifikasi sukses
                alert('Status berhasil diperbarui');
            } else {
                throw new Error('Update failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Kembalikan ke status sebelumnya
            select.value = originalStatus;
            alert('Gagal memperbarui status');
        })
        .finally(() => {
            // Enable kembali select
            select.disabled = false;
        });
    });
});
</script>
@endpush