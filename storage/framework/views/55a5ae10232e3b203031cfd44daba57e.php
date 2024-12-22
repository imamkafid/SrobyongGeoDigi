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
            <?php $__currentLoopData = $laporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="text-center">
                <td>#<?php echo e($item->id); ?></td>
                <td><?php echo e($item->created_at->format('d/m/Y H:i')); ?></td>
                <td><?php echo e($item->nik_pelapor); ?></td>
                <td>
                    <?php if($isAdmin): ?>
                        <select class="form-select form-select-sm status-select mx-auto" 
                                style="width: 130px;"
                                data-id="<?php echo e($item->id); ?>"
                                data-original="<?php echo e($item->status); ?>">
                            <?php $__currentLoopData = ['Menunggu', 'Proses', 'Selesai', 'Ditolak']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($status); ?>" 
                                        <?php echo e($item->status == $status ? 'selected' : ''); ?>>
                                    <?php echo e($status); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    <?php else: ?>
                        <span class="badge status-<?php echo e(strtolower($item->status)); ?>">
                            <?php echo e($item->status); ?>

                        </span>
                    <?php endif; ?>
                </td>
                <td>
                    <button class="btn btn-sm btn-info" 
                            onclick="showDetail(<?php echo e($item->id); ?>)"
                            title="Lihat Detail">
                        <i class="bi bi-eye-fill"></i>
                    </button>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\srobyong\SrobyongGeoDigi\resources\views/components/laporan-table.blade.php ENDPATH**/ ?>