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
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH C:\xampp\htdocs\srobyong\SrobyongGeoDigi\resources\views/components/laporan-tbody.blade.php ENDPATH**/ ?>